declare namespace mods="";
let $hz := collection("/books/")//mods:mods;
let $py := doc("books/pinyin/merge_py_wenlin2.xml");

for $nodes in $hz/@ID[., =$py//mods:mods/@ID]
return update insert $py/mods:namePart after $nodes/mods:namePart