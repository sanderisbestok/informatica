/* Useful debug macros. */

#ifdef DEBUG
#define DEBUG_PRINT(...) printf(__VA_ARGS__)
#define DEBUG_DO(x) x
#else
#define DEBUG_PRINT(...)
#define DEBUG_DO(x)
#endif

