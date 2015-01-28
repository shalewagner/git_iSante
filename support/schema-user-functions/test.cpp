
#include <sys/time.h>
#include <iostream>
#include "helpers.h"
#include "udf_itech.h"

using namespace std;

double now() {
  timeval tv;
  gettimeofday(&tv, NULL);
  return tv.tv_sec + ((double)tv.tv_usec/1000000);
}

int testLongFunction(int initCount,
		     int bodyCount,
		     int expected,
		     UDF_ARGS *args,
		     const char *label,
		     longlong (*xxx)(UDF_INIT*, UDF_ARGS *, char *, char *),
		     my_bool (*xxx_init)(UDF_INIT*, UDF_ARGS*, char*),
		     void (*xxx_deinit)(UDF_INIT*)
		     )
{
  longlong result;

  UDF_INIT initid;
  char message[255];
  char is_null[255];
  char error[255];

  double startTime = now();

  for (int i=0; i<initCount; i++) {
    (*xxx_init)(&initid, args, message);
    (*xxx_deinit)(&initid);
  }

  (*xxx_init)(&initid, args, message);
  result = (*xxx)(&initid, args, is_null, error);
  for (int i=0; i<bodyCount; i++) {
    (*xxx)(&initid, args, is_null, error);
  }
  (*xxx_deinit)(&initid);

  double endTime = now();

  const char *status;
  int returnValue;
  if (result == expected) {
    status = "OK";
    returnValue = 1;
  } else {
    status = "FAIL";
    returnValue = 0;
  }

  cout << status
       << " " << label << "=" << result
       << " t=" << (endTime - startTime) 
       << " i=" << initCount
       << " b=" << bodyCount
       << endl;

  return returnValue;
}

int testStringFunction(int initCount,
		       int bodyCount,
		       const char *expected,
		       UDF_ARGS *args,
		       const char *label,
		       char *(*xxx)(UDF_INIT *, UDF_ARGS *, char *, unsigned long *, char *, char *),
		       my_bool (*xxx_init)(UDF_INIT*, UDF_ARGS*, char*),
		       void (*xxx_deinit)(UDF_INIT*)
		       )
{
  char resultBuffer[255];
  char *result;

  UDF_INIT initid;
  char message[255];
  char is_null[255];
  char error[255];
  unsigned long length;

  double startTime = now();

  for (int i=0; i<initCount; i++) {
    (*xxx_init)(&initid, args, message);
    (*xxx_deinit)(&initid);
  }

  (*xxx_init)(&initid, args, message);
  result = (*xxx)(&initid, args, resultBuffer, &length, is_null, error);
  for (int i=0; i<bodyCount; i++) {
    (*xxx)(&initid, args, resultBuffer, &length, is_null, error);
  }
  (*xxx_deinit)(&initid);

  double endTime = now();

  const char *status;
  int returnValue;
  if ( (expected == NULL && is_null[0] == 1)
       || (expected != NULL && strcmp(result, expected) == 0 && is_null[0] == 0) ) {
    status = "OK";
    returnValue = 1;
  } else {
    status = "FAIL";
    returnValue = 0;
  }

  cout << status
       << " " << label << "=";
  if (is_null[0] == 0) {
    cout << "'" << result << "'";
  } else {
    cout << "NULL";
  }
  cout << " t=" << (endTime - startTime) 
       << " i=" << initCount
       << " b=" << bodyCount
       << endl;

  return returnValue;
}

int main(int argc, const char* argv[]) {

  int passedTests = 1;

  int iTests = 100000;
  int bTests = 100000;
  //iTests = 0;
  //bTests = 0;

  longlong intValue;
  longlong intValue1;
  longlong intValue2;

  int maxArgs = 3;
  UDF_ARGS udfArgs;
  enum Item_result arg_type[maxArgs];
  unsigned long lengths[maxArgs];
  char *args[maxArgs];
  char maybe_null;
  
  udfArgs.arg_type = arg_type;
  udfArgs.lengths = lengths;
  udfArgs.args = args;
  udfArgs.maybe_null = &maybe_null;

  cout << "Testing IsNumeric()" << endl;
  
  udfArgs.arg_count = 1;
  arg_type[0] = STRING_RESULT;

  args[0] = "123";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(iTests, 0, 1, &udfArgs, "IsNumeric('123')",
				  &IsNumeric, &IsNumeric_init, &IsNumeric_deinit);
  passedTests &= testLongFunction(0, bTests, 1, &udfArgs, "IsNumeric('123')",
				  &IsNumeric, &IsNumeric_init, &IsNumeric_deinit);
  args[0] = "123.123";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 1, &udfArgs, "IsNumeric('123.123')",
				  &IsNumeric, &IsNumeric_init, &IsNumeric_deinit);
  args[0] = "-123.123";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 1, &udfArgs, "IsNumeric('-123.123')",
				  &IsNumeric, &IsNumeric_init, &IsNumeric_deinit);
  args[0] = "123.";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 1, &udfArgs, "IsNumeric('123.')",
				  &IsNumeric, &IsNumeric_init, &IsNumeric_deinit);
  args[0] = ".123";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 1, &udfArgs, "IsNumeric('.123')",
				  &IsNumeric, &IsNumeric_init, &IsNumeric_deinit);
  args[0] = "123e1";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 1, &udfArgs, "IsNumeric('123e1')",
				  &IsNumeric, &IsNumeric_init, &IsNumeric_deinit);
  args[0] = " 123";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 1, &udfArgs, "IsNumeric(' 123')",
				  &IsNumeric, &IsNumeric_init, &IsNumeric_deinit);
  args[0] = "123 ";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 1, &udfArgs, "IsNumeric('123 ')",
				  &IsNumeric, &IsNumeric_init, &IsNumeric_deinit);

  args[0] = "0xff";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 0, &udfArgs, "IsNumeric('0xff')",
				  &IsNumeric, &IsNumeric_init, &IsNumeric_deinit);
  args[0] = "123abc";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 0, &udfArgs, "IsNumeric('123abc')",
				  &IsNumeric, &IsNumeric_init, &IsNumeric_deinit);
  args[0] = "abc";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 0, &udfArgs, "IsNumeric('abc')",
				  &IsNumeric, &IsNumeric_init, &IsNumeric_deinit);
  args[0] = "abc123abc";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 0, &udfArgs, "IsNumeric('abc123abc')",
				  &IsNumeric, &IsNumeric_init, &IsNumeric_deinit);
  args[0] = "";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 0, &udfArgs, "IsNumeric('')",
				  &IsNumeric, &IsNumeric_init, &IsNumeric_deinit);
  
  arg_type[0] = INT_RESULT;

  intValue = 123;
  args[0] = (char*)&intValue;
  lengths[0] = 3;
  passedTests &= testLongFunction(0, bTests, 1, &udfArgs, "IsNumeric(123)",
				  &IsNumeric, &IsNumeric_init, &IsNumeric_deinit);

  intValue = 0;
  args[0] = (char*)&intValue;
  lengths[0] = 1;
  passedTests &= testLongFunction(0, bTests, 1, &udfArgs, "IsNumeric(0)",
				  &IsNumeric, &IsNumeric_init, &IsNumeric_deinit);

  args[0] = NULL;
  lengths[0] = 1;
  passedTests &= testLongFunction(0, bTests, 0, &udfArgs, "IsNumeric(NULL)",
				  &IsNumeric, &IsNumeric_init, &IsNumeric_deinit);

  cout << endl;


  cout << "Testing IsDate()" << endl;
  udfArgs.arg_count = 1;
  arg_type[0] = STRING_RESULT;

  args[0] = "2009-07-06";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(iTests, 0, 1, &udfArgs, "IsDate('2009-07-06')",
				  &IsDate, &IsDate_init, &IsDate_deinit);

  arg_type[0] = INT_RESULT;
  args[0] = (char*)&intValue;
  intValue = 130706;
  lengths[0] = 6;
  passedTests &= testLongFunction(0, bTests, 1, &udfArgs, "IsDate(130706)",
				  &IsDate, &IsDate_init, &IsDate_deinit);
  intValue = 20090706;
  lengths[0] = 8;
  passedTests &= testLongFunction(0, bTests, 1, &udfArgs, "IsDate(20090706)",
				  &IsDate, &IsDate_init, &IsDate_deinit);

  arg_type[0] = STRING_RESULT;
  args[0] = "090706";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 1, &udfArgs, "IsDate('090706')",
				  &IsDate, &IsDate_init, &IsDate_deinit);
  args[0] = "20090706";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 1, &udfArgs, "IsDate('20090706')",
				  &IsDate, &IsDate_init, &IsDate_deinit);
  args[0] = " 20090706 ";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 1, &udfArgs, "IsDate(' 20090706 ')",
				  &IsDate, &IsDate_init, &IsDate_deinit);
  args[0] = "2009-07-06";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 1, &udfArgs, "IsDate('2009-07-06')",
				  &IsDate, &IsDate_init, &IsDate_deinit);
  args[0] = " 2009-07-06 ";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 1, &udfArgs, "IsDate(' 2009-07-06 ')",
				  &IsDate, &IsDate_init, &IsDate_deinit);
  args[0] = "2009-07-6";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 1, &udfArgs, "IsDate('2009-07-6')",
				  &IsDate, &IsDate_init, &IsDate_deinit);
  args[0] = "2009-7-6";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 1, &udfArgs, "IsDate('2009-7-6')",
				  &IsDate, &IsDate_init, &IsDate_deinit);
  args[0] = "9-07-06";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 1, &udfArgs, "IsDate('9-07-06')",
				  &IsDate, &IsDate_init, &IsDate_deinit);
  args[0] = "2009-07.06";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 1, &udfArgs, "IsDate('2009-07.06')",
				  &IsDate, &IsDate_init, &IsDate_deinit);
  args[0] = "2009.07.06";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 1, &udfArgs, "IsDate('2009.07.06')",
				  &IsDate, &IsDate_init, &IsDate_deinit);
  args[0] = "2009.06.30";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 1, &udfArgs, "IsDate('2009.06.30')",
				  &IsDate, &IsDate_init, &IsDate_deinit);
  args[0] = "2009/06/30";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 1, &udfArgs, "IsDate('2009/06/30')",
				  &IsDate, &IsDate_init, &IsDate_deinit);
  args[0] = "009.06.30";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 1, &udfArgs, "IsDate('009.06.30')",
				  &IsDate, &IsDate_init, &IsDate_deinit);

  arg_type[0] = INT_RESULT;
  args[0] = (char*)&intValue;
  intValue = 20090631;
  lengths[0] = 8;
  passedTests &= testLongFunction(0, bTests, 0, &udfArgs, "IsDate(20090631)",
				  &IsDate, &IsDate_init, &IsDate_deinit);

  arg_type[0] = STRING_RESULT;
  args[0] = "130-07-06";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 0, &udfArgs, "IsDate('130-07-06')",
				  &IsDate, &IsDate_init, &IsDate_deinit);
  args[0] = "13-07-06";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 0, &udfArgs, "IsDate('13-07-06')",
				  &IsDate, &IsDate_init, &IsDate_deinit);
  args[0] = "2009.06.31";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 0, &udfArgs, "IsDate('2009.06.31')",
				  &IsDate, &IsDate_init, &IsDate_deinit);
  args[0] = "xxxx-07-06";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 0, &udfArgs, "IsDate('xxxx-07-06')",
				  &IsDate, &IsDate_init, &IsDate_deinit);
  args[0] = "xx-07-06";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 0, &udfArgs, "IsDate('xx-07-06')",
				  &IsDate, &IsDate_init, &IsDate_deinit);
  args[0] = "2009-0x-06";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 0, &udfArgs, "IsDate('2009-0x-06')",
				  &IsDate, &IsDate_init, &IsDate_deinit);
  args[0] = "2009-07-xx";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 0, &udfArgs, "IsDate('2009-07-xx')",
				  &IsDate, &IsDate_init, &IsDate_deinit);
  args[0] = "2009--07-06";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 0, &udfArgs, "IsDate('2009--07-06')",
				  &IsDate, &IsDate_init, &IsDate_deinit);
  args[0] = "0000-00-00";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 0, &udfArgs, "IsDate('0000-00-00')",
				  &IsDate, &IsDate_init, &IsDate_deinit);
  args[0] = "1752-12-01";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 0, &udfArgs, "IsDate('1752-12-01')",
				  &IsDate, &IsDate_init, &IsDate_deinit);
  args[0] = "";
  lengths[0] = strlen(args[0]);
  passedTests &= testLongFunction(0, bTests, 0, &udfArgs, "IsDate('')",
				  &IsDate, &IsDate_init, &IsDate_deinit);
  args[0] = NULL;
  lengths[0] = 1;
  passedTests &= testLongFunction(0, bTests, 0, &udfArgs, "IsDate(NULL)",
				  &IsDate, &IsDate_init, &IsDate_deinit);

  cout << endl;


  cout << "Testing ymdToDate()" << endl;

  udfArgs.arg_count = 3;

  arg_type[0] = STRING_RESULT;
  arg_type[1] = STRING_RESULT;
  arg_type[2] = STRING_RESULT;
  args[0] = "2009";
  lengths[0] = strlen(args[0]);
  args[1] = "07";
  lengths[1] = strlen(args[1]);
  args[2] = "06";
  lengths[2] = strlen(args[2]);
  passedTests &= testStringFunction(iTests, 0, "2009-07-06", &udfArgs,
				    "ymdToDate('2009','07','06')",
				    &ymdToDate, &ymdToDate_init, &ymdToDate_deinit);
  passedTests &= testStringFunction(0, bTests, "2009-07-06", &udfArgs,
				    "ymdToDate('2009','07','06')",
				    &ymdToDate, &ymdToDate_init, &ymdToDate_deinit);
  args[1] = "7";
  lengths[1] = strlen(args[1]);
  args[2] = "6";
  lengths[2] = strlen(args[2]);
  passedTests &= testStringFunction(0, bTests, "2009-07-06", &udfArgs,
				    "ymdToDate('2009','7','6')",
				    &ymdToDate, &ymdToDate_init, &ymdToDate_deinit);
  args[0] = "9";
  lengths[0] = strlen(args[0]);
  args[1] = "07";
  lengths[1] = strlen(args[1]);
  args[2] = "06";
  lengths[2] = strlen(args[2]);
  passedTests &= testStringFunction(0, bTests, "2009-07-06", &udfArgs,
				    "ymdToDate('9','07','06')",
				    &ymdToDate, &ymdToDate_init, &ymdToDate_deinit);
  args[0] = "9ab";
  lengths[0] = strlen(args[0]);
  args[1] = "07";
  lengths[1] = strlen(args[1]);
  args[2] = "06";
  lengths[2] = strlen(args[2]);
  passedTests &= testStringFunction(0, bTests, "9ab-07-06", &udfArgs,
				    "ymdToDate('9ab','07','06')",
				    &ymdToDate, &ymdToDate_init, &ymdToDate_deinit);
  args[0] = " 2009 ";
  lengths[0] = strlen(args[0]);
  args[1] = " 07 ";
  lengths[1] = strlen(args[1]);
  args[2] = " 06 ";
  lengths[2] = strlen(args[2]);
  passedTests &= testStringFunction(0, bTests, NULL, &udfArgs,
				    "ymdToDate(' 2009 ',' 07 ',' 06 ')",
				    &ymdToDate, &ymdToDate_init, &ymdToDate_deinit);
  args[0] = "200009";
  lengths[0] = strlen(args[0]);
  args[1] = "7000";
  lengths[1] = strlen(args[1]);
  args[2] = "0600";
  lengths[2] = strlen(args[2]);
  passedTests &= testStringFunction(0, bTests, "2000-70-06", &udfArgs,
				    "ymdToDate('200009','7000','0600')",
				    &ymdToDate, &ymdToDate_init, &ymdToDate_deinit);
  args[0] = "abcabcd";
  lengths[0] = strlen(args[0]);
  args[1] = "07";
  lengths[1] = strlen(args[1]);
  args[2] = "06";
  lengths[2] = strlen(args[2]);
  passedTests &= testStringFunction(0, bTests, "abca-07-06", &udfArgs,
				    "ymdToDate('abcabcd','07','06')",
				    &ymdToDate, &ymdToDate_init, &ymdToDate_deinit);
  args[0] = "xx";
  lengths[0] = strlen(args[0]);
  args[1] = "x";
  lengths[1] = strlen(args[1]);
  args[2] = "06";
  lengths[2] = strlen(args[2]);
  passedTests &= testStringFunction(0, bTests, "xx-0x-06", &udfArgs,
				    "ymdToDate('xx','x','06')",
				    &ymdToDate, &ymdToDate_init, &ymdToDate_deinit);
  args[0] = "2009";
  lengths[0] = strlen(args[0]);
  args[1] = "07";
  lengths[1] = strlen(args[1]);
  args[2] = "";
  lengths[2] = strlen(args[2]);
  passedTests &= testStringFunction(0, bTests, NULL, &udfArgs,
				    "ymdToDate('2009','07','')",
				    &ymdToDate, &ymdToDate_init, &ymdToDate_deinit);
  args[0] = "";
  lengths[0] = strlen(args[0]);
  args[1] = "";
  lengths[1] = strlen(args[1]);
  args[2] = "06";
  lengths[2] = strlen(args[2]);
  passedTests &= testStringFunction(0, bTests, NULL, &udfArgs,
				    "ymdToDate('','','06')",
				    &ymdToDate, &ymdToDate_init, &ymdToDate_deinit);
  args[0] = "0";
  lengths[0] = strlen(args[0]);
  args[1] = "0";
  lengths[1] = strlen(args[1]);
  args[2] = "0";
  lengths[2] = strlen(args[2]);
  passedTests &= testStringFunction(0, bTests, NULL, &udfArgs,
				    "ymdToDate('0','0','0')",
				    &ymdToDate, &ymdToDate_init, &ymdToDate_deinit);
  args[0] = "1";
  lengths[0] = strlen(args[0]);
  args[1] = "1";
  lengths[1] = strlen(args[1]);
  args[2] = "00";
  lengths[2] = strlen(args[2]);
  passedTests &= testStringFunction(0, bTests, NULL, &udfArgs,
				    "ymdToDate('1','1','00')",
				    &ymdToDate, &ymdToDate_init, &ymdToDate_deinit);
  args[0] = "9";
  lengths[0] = strlen(args[0]);
  args[1] = NULL;
  lengths[1] = 0;
  args[2] = "06";
  lengths[2] = strlen(args[2]);
  passedTests &= testStringFunction(0, bTests, NULL, &udfArgs,
				    "ymdToDate('9',NULL,'06')",
				    &ymdToDate, &ymdToDate_init, &ymdToDate_deinit);

  args[0] = "2009";
  lengths[0] = strlen(args[0]);
  args[1] = "7";
  lengths[1] = strlen(args[1]);
  intValue2 = 6;
  arg_type[2] = INT_RESULT;
  args[2] = (char*)&intValue2;
  lengths[2] = 1;
  passedTests &= testStringFunction(0, bTests, "2009-07-06", &udfArgs,
				    "ymdToDate('2009','7',6)",
				    &ymdToDate, &ymdToDate_init, &ymdToDate_deinit);
  intValue = 2009;
  arg_type[0] = INT_RESULT;
  args[0] = (char*)&intValue;
  lengths[0] = 4;
  intValue1 = 7;
  arg_type[1] = INT_RESULT;
  args[1] = (char*)&intValue1;
  lengths[1] = 1;
  passedTests &= testStringFunction(0, bTests, "2009-07-06", &udfArgs,
				    "ymdToDate(2009,7,6)",
				    &ymdToDate, &ymdToDate_init, &ymdToDate_deinit);
  intValue = 9;
  arg_type[0] = INT_RESULT;
  args[0] = (char*)&intValue;
  lengths[0] = 1;
  passedTests &= testStringFunction(0, bTests, "2009-07-06", &udfArgs,
				    "ymdToDate(9,7,6)",
				    &ymdToDate, &ymdToDate_init, &ymdToDate_deinit);
  intValue2 = 0;
  arg_type[2] = INT_RESULT;
  args[2] = (char*)&intValue2;
  lengths[2] = 1;
  passedTests &= testStringFunction(0, bTests, NULL, &udfArgs,
				    "ymdToDate(9,7,0)",
				    &ymdToDate, &ymdToDate_init, &ymdToDate_deinit);

  cout << endl;

  if (passedTests == 1) {
    cout << "Everything is OK" << endl;
    return 0;
  } else {
    cout << "Some tests failed" << endl;
    return 1;
  }
}
