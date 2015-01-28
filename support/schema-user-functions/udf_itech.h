
#ifndef UDF_ITECH_H_GUARD
#define UDF_ITECH_H_GUARD

#ifdef STANDARD
/* STANDARD is defined, don't use any mysql functions */
#include <stdlib.h>
#include <stdio.h>
#include <string.h>
#ifdef __WIN__
typedef unsigned __int64 ulonglong;	/* Microsofts 64 bit types */
typedef __int64 longlong;
#else
typedef unsigned long long ulonglong;
typedef long long longlong;
#endif /*__WIN__*/
#else
#include <my_global.h>
#include <my_sys.h>
#if defined(MYSQL_SERVER)
#include <m_string.h>		/* To get strmov() */
#else
/* when compiled as standalone */
#include <string.h>
#define strmov(a,b) stpcpy(a,b)
#define bzero(a,b) memset(a,0,b)
#define memcpy_fixed(a,b,c) memcpy(a,b,c)
#endif
#endif
#include <mysql.h>
#include <ctype.h>

#ifdef HAVE_DLOPEN

/* These must be right or mysqld will not find the symbol! */
extern "C" {
  my_bool IsDate_init(UDF_INIT *initid, UDF_ARGS *args, char *message);
  void IsDate_deinit(UDF_INIT *initid);
  longlong IsDate(UDF_INIT *initid, UDF_ARGS *args, char *is_null, char *error);

  my_bool IsNumeric_init(UDF_INIT *initid, UDF_ARGS *args, char *message);
  void IsNumeric_deinit(UDF_INIT *initid);
  longlong IsNumeric(UDF_INIT *initid, UDF_ARGS *args, char *is_null, char *error);

  my_bool ymdToDate_init(UDF_INIT *initid, UDF_ARGS *args, char *message);
  void ymdToDate_deinit(UDF_INIT *initid);
  char *ymdToDate(UDF_INIT *initid, UDF_ARGS *args, char *result,
		   unsigned long *length, char *is_null, char *error);
}

#endif /* HAVE_DLOPEN */

#endif
