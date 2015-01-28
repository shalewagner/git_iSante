
#include <stdlib.h>
#include <string.h>
#include "php.h"
#include "HsFFI.h"

#include "CLibrary_stub.h"


/* prototypes */
PHP_MINIT_FUNCTION(itech_sql);
PHP_MSHUTDOWN_FUNCTION(itech_sql);
PHP_FUNCTION(itech_hello_world);
PHP_FUNCTION(itech_translateSql);
PHP_FUNCTION(itech_splitSql);

extern zend_module_entry hello_module_entry;


#ifdef __GLASGOW_HASKELL__
extern void __stginit_CLibrary(void);
#endif


static function_entry itech_sql_functions[] = {
  PHP_FE(itech_hello_world, NULL)
  PHP_FE(itech_translateSql, NULL)
  PHP_FE(itech_splitSql, NULL)
  {NULL, NULL, NULL}
};

zend_module_entry itech_sql_module_entry = {
#if ZEND_MODULE_API_NO >= 20010901
  STANDARD_MODULE_HEADER,
#endif
  "itech_sql",
  itech_sql_functions,
  PHP_MINIT(itech_sql),
  PHP_MSHUTDOWN(itech_sql),
  NULL,
  NULL,
  NULL,
#if ZEND_MODULE_API_NO >= 20010901
  "1.0",
#endif
  STANDARD_MODULE_PROPERTIES
};



#ifdef COMPILE_DL
ZEND_GET_MODULE(itech_sql)
#endif



PHP_MINIT_FUNCTION(itech_sql) {
  int argc = 1;

  char staticArg0[] = "php";
  char* arg0 = malloc(100 * sizeof (char));
  strcpy(arg0, staticArg0);

  char** argv;
  argv = malloc(1 * sizeof (char *));
  argv[0] = arg0;

  hs_init(&argc, &argv);
#ifdef __GLASGOW_HASKELL__
  hs_add_root(__stginit_CLibrary);
#endif

  return SUCCESS;
}

PHP_MSHUTDOWN_FUNCTION(itech_sql) {
  hs_exit();
  return SUCCESS;
}

PHP_FUNCTION(itech_hello_world) {
  /*
  char* helloString = (char*)helloWorld();

  char* stringAddress = malloc(100 * sizeof (char));
  sprintf(stringAddress, "%d", helloString);

  free(helloString);
  */
  RETURN_STRING("Hello World", 1);
}

PHP_FUNCTION(itech_translateSql) {
  char *sql;
  int sqlLength;

  if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s", &sql, &sqlLength) == FAILURE) {
    RETURN_NULL();
  }

  char** hReturn = (char**)translateSql((HsPtr)sql);
  char* type = hReturn[0];
  char* message = hReturn[1];

  array_init(return_value);
  add_next_index_string(return_value, type, 1);
  add_next_index_string(return_value, message, 1);

  free(hReturn);
  free(type);
  free(message);
}

PHP_FUNCTION(itech_splitSql) {
  char *sql;
  int sqlLength;

  if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s", &sql, &sqlLength) == FAILURE) {
    RETURN_NULL();
  }

  void** hReturn = (void**)splitSql((HsPtr)sql);
  int* count = (int*)hReturn[0];

  array_init(return_value);
  add_next_index_long(return_value, (long)*count);

  if (*count == 0) {
    char* errorMessage = (char*)hReturn[1];
    add_next_index_string(return_value, errorMessage, 1);
    free(errorMessage);
  } else {
    int i;
    for (i=1; i<=*count; i++) {
      char* sql = (char*)hReturn[i];
      add_next_index_string(return_value, sql, 1);
      free(sql);
    }
  }

  free(hReturn);
  free(count);
}
