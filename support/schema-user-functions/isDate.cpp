
#include <boost/date_time/gregorian/gregorian.hpp>
#include "udf_itech.h"
#include "helpers.h"


my_bool IsDate_init(UDF_INIT *initid, UDF_ARGS *args, char *message) {
  if (args->arg_count != 1) {
    strcpy(message, "Wrong number of arguments to IsDate.");
    return 1;
  }

  initid->maybe_null = 0; /* never returns null */
  initid->max_length = 1; /* return 0 or 1 */
  return 0;
}

void IsDate_deinit(UDF_INIT *initid) {
}

longlong IsDate(UDF_INIT *initid, UDF_ARGS *args, char *is_null, char *error) {

  if (args->args[0] == NULL) {
    return 0; //NULL values are not dates
  }

  char *endptr; //used for strtol, ignored

  longlong parameterInt; //holds input if the input is a single integer
  bool shouldProcessInt = false; //set to true if processing parameterInt
  char parameterStringBuffer[32]; //buffer to hold a copy of string input
  char *parameterString = parameterStringBuffer; //pointer to string input
  int parameterLength; //length of string input

  //hold numeric info extracted from the input argument
  longlong year;
  longlong month;
  longlong day;

  //used when verifying string input
  int symbolsFound = 0; //number of [/.-] symbols found
  char *symbolOffsets[2]; //pointer to the first two symbols found 
  int ymdLengths[3] = {0,0,0}; //how long were each numeric expression inbetween symbols

  switch (args->arg_type[0]) {
  case STRING_RESULT:
    //if the string is bigger then what will fit into stringValue only use the first 31 chars
    if (args->lengths[0] < 31) {
      parameterLength = args->lengths[0];
    } else {
      parameterLength = 31;
    }

    //copy into stringValue
    strncpy(parameterString, args->args[0], parameterLength);

    //make sure it is null terminated
    parameterString[parameterLength] = '\0';

    //ignore any white space
    parameterString = trimWhiteSpace(parameterString);
    parameterLength = strlen(parameterString);

    //verify that input is correct format
    //this is trying to emulate ^([0-9]+)([/.-]([0-9]+)[/.-]([0-9]+))?$
    for (char *i = parameterString; *i != '\0'; i++) {
      if (*i == '-' || *i == '.' || *i == '/') {
	if (symbolsFound == 2) {
	  return 0; //can not have more then 2 symbols
	} else {
	  symbolOffsets[symbolsFound] = i;
	  symbolsFound++;
	}
      } else if (isdigit(*i)) {
	ymdLengths[symbolsFound]++;
      } else {
	return 0; //not 0-9 or [-./]
      }
    }

    if (symbolsFound == 0 && (parameterLength == 8 || parameterLength == 6)) {
      //Process YYYYMMDD or YYMMDD formated string
      parameterInt = strtoll(parameterString, &endptr, 10);
      shouldProcessInt = true;
    } else if (symbolsFound == 2 && ymdLengths[1] != 0 && ymdLengths[2] != 0) {
      //Extract year, month, day using captured sub expressions
      //Set the [/.-] characters to \0
      *symbolOffsets[0] = '\0';
      *symbolOffsets[1] = '\0';
      year = strtol(parameterString, &endptr, 10);
      if (year > 999) {
	month = strtol(symbolOffsets[0]+1, &endptr, 10);
	day = strtol(symbolOffsets[1]+1, &endptr, 10);
      } else {
	month = year;
	day = strtol(symbolOffsets[0]+1, &endptr, 10);
	year = strtol(symbolOffsets[1]+1, &endptr, 10);
      }
      year = fix2DigitYear(year);
    } else {
      return 0; //failed to capture three sub expressions
    }
    break;
  case INT_RESULT:
    parameterInt = *((longlong*)args->args[0]);
    if ( (parameterInt >= 10000000 && parameterInt <= 99999999)
	 || (parameterInt >= 100000 && parameterInt <= 999999) ) {
      shouldProcessInt = true;
    } else {
      return 0;
    }
    break;
  case REAL_RESULT:
    return 0; //floating point numbers are never dates
    break;
  default:
    break;
  }

  if (shouldProcessInt) {
    if (parameterInt < 0) {
      return 0; //negative numbers are never a date
    }
    year = parameterInt / 10000;
    month = (parameterInt - year * 10000) / 100;
    day = parameterInt - year * 10000 - month * 100;
    year = fix2DigitYear(year);
  }

  //validate month
  if (month < 1 || month > 12) {
    return 0; //month not 1-12
  }

  //validate year
  if (year < 1753 || year > 9999) {
    return 0; //year not 1753-9999
  }

  //validate day of month
  unsigned int endOfMonth;
  try {
    endOfMonth = boost::gregorian::gregorian_calendar::end_of_month_day(year, month);
  } catch (std::exception& e) {
    return 0; //year range not valid for end_of_month_day()
  }
  if (day < 1 || day > endOfMonth) {
    return 0; //day not 1-endOfMonth
  }

  return 1; //everything is ok, it's a valid date
}
