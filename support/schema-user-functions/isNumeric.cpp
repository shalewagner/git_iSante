
#include "udf_itech.h"

my_bool IsNumeric_init(UDF_INIT *initid, UDF_ARGS *args, char *message) {
  if (args->arg_count != 1) {
    strcpy(message, "Wrong number of arguments to IsNumeric.");
    return 1;
  }

  initid->maybe_null = 0; /* never returns null */
  initid->max_length = 1; /* return 0 or 1 */
  return 0;
}

void IsNumeric_deinit(UDF_INIT *initid) {
}

longlong IsNumeric(UDF_INIT *initid, UDF_ARGS *args, char *is_null, char *error) {

  //these are all used when the argument is type STRING_RESULT
  double value; //store the value converted from the string
  char stringValue[32]; //buffer to hold the string value (so we can null terminate it)
  int stringLength; //length of the string value
  char *endptr; //pointer to the location in the string where strtod stopped conversion

  if (args->args[0] == NULL) {
    return 0;
  }

  switch (args->arg_type[0]) {
  case STRING_RESULT:
    //if the string is bigger then what will fit into stringValue only use the first 31 chars
    if (args->lengths[0] < 31) {
      stringLength = args->lengths[0];
    } else {
      stringLength = 31;
    }

    //copy into stringValue
    strncpy(stringValue, args->args[0], stringLength);

    //make sure it is null terminated
    stringValue[stringLength] = '\0';

    //ttempt to convert to double.
    //This method ended up being faster then a regex and C++ stream operators
    value = strtod(stringValue, &endptr);

    //If endptr is currently pointing to whitespace then advance it until that is no longer the case.
    //This makes it look like strtod consumed trailing white space during conversion.
    while (isspace(*endptr)) {
      endptr++;
    }

    //Was the conversion successful?
    if ( (stringValue == endptr) //endptr pointing to the start of the string
    	 || (endptr != stringValue + stringLength) //endptr not pointing at the end of the string
	 || (strpbrk(stringValue, "xX")) ) { //The string contains x or X (don't want hex numbers)
      return 0; //failed
    } else {
      return 1;
    }
    break;
  case INT_RESULT:
    return 1;
    break;
  case REAL_RESULT:
    return 1;
    break;
  default:
    break;
  }

  return 0; /* should never get here */
}
