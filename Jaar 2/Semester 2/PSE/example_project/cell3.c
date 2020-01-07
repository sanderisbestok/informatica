
list_add(shoppinglist, a, CHAR);
list_add(shoppinglist, &b, FLOAT);
list_add(shoppinglist, &c, INT);
list_print(shoppinglist);
// Should trigger a compile error
list_non_existing_func();