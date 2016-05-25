xquery version "3.0";

declare namespace mods ="http://www.loc.gov/mods/v3";
declare namespace tei ="http://www.tei-c.org/ns/1.0";
declare namespace xi = "http://www.w3.org/2003/XInclude";
declare namespace xlink="http://www.w3.org/1999/xlink";

declare default element namespace "http://www.loc.gov/mods/v3";


declare variable $py := doc("/db/IN/german/pinyin/merge_py_wenlin2.xml")/mods:modsCollection;
declare variable $hz := collection('/db/IN/german/books');

declare  function local:upName($source as node()*) as item()*  {
let $trans := $py/mods:mods/@ID[. = $source/@ID]
 return update
 insert 
    <namePart lang="chi" transliteration="chinese/ala-lc">{$trans/..//mods:namePart/text()}</namePart> 
    preceding $source//mods:role
    
};       


declare function local:upTitle($source as node()*) as item()* {
let $trans := $py/mods:mods/@ID[. = $source/@ID]
return update
    insert  <titleInfo type="translated" transliteration="chinese/ala-lc">
                <title>{$trans/..//mods:titleInfo/mods:title/text()}</title>
            </titleInfo> 
    following $source/mods:titleInfo
};

declare  function local:inLang($source as node()*) as item()* {
let $trans := $py/mods:mods/@ID[. = $source/@ID]
return update
    insert  <language>
                <languageTerm type="code" authority="iso639-2b"/>
            </language> 
    preceding $source/mods:identifier
};

declare  function local:inRec($source as node()*) as item()* {
let $trans := $py/mods:mods/@ID[. = $source/@ID]
return update
    insert  <recordInfo>
                <recordOrigin>exported from MHDB database</recordOrigin>
            </recordInfo> 
    preceding $source/mods:identifier
};




for $source in $hz/mods:mods

let $name := local:upName($source)
let $title := local:upTitle($source)
let $lang := local:inLang($source)


return local:inRec($source)


  
(:TEST :)

(:return:)
(:    <new>:)
(:        {$trans/../mods:namePart}:)
(:        {$trans/../mods:titleInfo}:)
(:        {$source/..}:)
(:    </new>:)

