
#include <string.h>
#include <ctype.h>

long long fix2DigitYear(long long year) {
  if (year >= 1000) { /* four digit years */
    return year;
  } else if (year <= 15) { /* two digit years in the 2000s */
    return year + 2000;
  } else { /* two digit years in the 1900s (also works with three digit years like 105) */
    return year + 1900;
  }
}

char *trimWhiteSpace(char *str) {
  char *end;

  // Trim leading space
  while (isspace(*str)) str++;

  // Trim trailing space
  end = str + strlen(str) - 1;
  while (end > str && isspace(*end)) end--;

  // Write new null terminator
  *(end+1) = 0;

  return str;
}
