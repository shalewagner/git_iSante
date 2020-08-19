#define IN_STG_CODE 0
#include "Rts.h"
#include "Stg.h"
#ifdef __cplusplus
extern "C" {
#endif
 
extern StgClosure CLibrary_zdftranslateSqlCWrapperzuaa11_closure;
HsPtr translateSql(HsPtr a1)
{
Capability *cap;
HaskellObj ret;
HsPtr cret;
cap = rts_lock();
cap=rts_evalIO(cap,rts_apply(cap,(HaskellObj)runIO_closure,rts_apply(cap,&CLibrary_zdftranslateSqlCWrapperzuaa11_closure,rts_mkPtr(cap,a1))) ,&ret);
rts_checkSchedStatus("translateSql",cap);
cret=rts_getPtr(ret);
rts_unlock(cap);
return cret;
}
 
extern StgClosure CLibrary_zdfsplitSqlCWrapperzuaa10_closure;
HsPtr splitSql(HsPtr a1)
{
Capability *cap;
HaskellObj ret;
HsPtr cret;
cap = rts_lock();
cap=rts_evalIO(cap,rts_apply(cap,(HaskellObj)runIO_closure,rts_apply(cap,&CLibrary_zdfsplitSqlCWrapperzuaa10_closure,rts_mkPtr(cap,a1))) ,&ret);
rts_checkSchedStatus("splitSql",cap);
cret=rts_getPtr(ret);
rts_unlock(cap);
return cret;
}
static void stginit_export_CLibrary_zdftranslateSqlCWrapperzuaa11() __attribute__((constructor));
static void stginit_export_CLibrary_zdftranslateSqlCWrapperzuaa11()
{getStablePtr((StgPtr) &CLibrary_zdftranslateSqlCWrapperzuaa11_closure);}
static void stginit_export_CLibrary_zdfsplitSqlCWrapperzuaa10() __attribute__((constructor));
static void stginit_export_CLibrary_zdfsplitSqlCWrapperzuaa10()
{getStablePtr((StgPtr) &CLibrary_zdfsplitSqlCWrapperzuaa10_closure);}
#ifdef __cplusplus
}
#endif

