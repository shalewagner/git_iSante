
#include "udf_itech.h"
#include "helpers.h"

my_bool ymdToDate_init(UDF_INIT *initid, UDF_ARGS *args, char *message) {
  if (args->arg_count != 3) {
    strcpy(message, "Wrong number of arguments to ymdToDate.");
    return 1;
  }

  initid->maybe_null = 1; // can return null even if input is not null'able 
  initid->max_length = 10; // should always be a 10 character string 
  return 0;
}

void ymdToDate_deinit(UDF_INIT *initid) {
}

char *ymdToDate(UDF_INIT *initid, UDF_ARGS *args, char *result,
		 unsigned long *length, char *is_null, char *error) {
  *is_null = 1; //default to null output
  *length = 0;
  if (args->args[0] == NULL || args->args[1] == NULL || args->args[2] == NULL
      || args->arg_type[0] == REAL_RESULT 
      || args->arg_type[1] == REAL_RESULT
      || args->arg_type[2] == REAL_RESULT) {
    return result; //no NULL input, no REAL_RESULT types, will check for empty strings later
  }

  //the result is built progressively, this pointer hold the location where the next piece of the result should be written to
  char *resultPointer = result;

  //these are used for processing the year input
  char yearBuffer[5]; //hold a copy of the year input value
  char *year = yearBuffer;
  int yearLength;
  longlong yearNumber; //if year input is a number store it here
  char *endptr; //used to test if strtoll() was succesful
  
  switch (args->arg_type[0]) {
  case STRING_RESULT:
    //make a copy of year input, null terminate it, remove white space
    yearLength = args->lengths[0] < 4 ? args->lengths[0] : 4;
    strncpy(year, ((char*)args->args[0]), yearLength);
    year[yearLength] = '\0';
    year = trimWhiteSpace(year);
    yearLength = strlen(year);

    if (yearLength == 0) {
      return result; //no empty year strings
    }

    //If year is numeric run it through fix2DigitYear
    yearNumber = strtoll(year, &endptr, 10);
    if ( (endptr != year) //conversion succeeded
	 && (endptr == year + yearLength) ) { //conversion consumed the whole string
      resultPointer += sprintf(resultPointer, "%lld", fix2DigitYear(yearNumber));
    } else { //not numeric so just copy it to the output
      strcpy(resultPointer, year);
      resultPointer += yearLength;
    }
    break;
  case INT_RESULT:
    //need to stringify into yearBuffer first so that it can be truncated to 4 digits
    snprintf(yearBuffer, 5, "%lld", fix2DigitYear(*((longlong*)args->args[0])));
    strcpy(resultPointer, yearBuffer);
    resultPointer += strlen(yearBuffer);
    break;
  default:
    break;
  }


  // month and day inputs are both processed in the same way
  char monthBuffer[3];
  char dayBuffer[3];
  char *monthAndDay[2];
  monthAndDay[0] = monthBuffer;
  monthAndDay[1] = dayBuffer;

  for (int i=1; i<=2; i++) {
    char *valueBuffer = monthAndDay[i-1];
    char *value = valueBuffer;
    int valueLength = args->lengths[i] < 2 ? args->lengths[i] : 2;

    //add - to the output
    *resultPointer = '-';
    resultPointer++;
    
    switch (args->arg_type[i]) {
    case STRING_RESULT:
      //make a copy of input, null terminate it, remove white space
      strncpy(value, ((char*)args->args[i]), valueLength);
      value[valueLength] = '\0';
      value = trimWhiteSpace(value);
      valueLength = strlen(value);

      if (valueLength == 0) {
	return result; //no empty value strings
      } else if (valueLength == 1) {
	if (strcmp("0", value) == 0) {
	  return result; //no values of "0"
	}
	//need to 0 pad it
	valueBuffer[1] = value[0];
	valueBuffer[0] = '0';
	valueBuffer[2] = '\0';
	value = valueBuffer;
	valueLength = 2;
      } else if (strcmp("00", value) == 0) {
	return result; //no values of "00"
      }

      //copy to result
      strcpy(resultPointer, value);
      resultPointer += valueLength;
      break;
    case INT_RESULT:
      //no zeros
      if (*((longlong*)args->args[i]) == 0) {
	return result;
      }
      //need to stringify first so that it can be truncated to 2 digits
      snprintf(valueBuffer, 3, "%02lld", *((longlong*)args->args[i]));
      strcpy(resultPointer, valueBuffer);
      resultPointer += strlen(valueBuffer);
      break;
    default:
      break;
    }
  }

  *length = strlen(result);
  //sanity check
  if (*length > 10) {
    return result; //should never get here 
  }

  *is_null = 0;
  return result;
}
