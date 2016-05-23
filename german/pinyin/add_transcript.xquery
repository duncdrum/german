xquery version "3.0";



declare namespace mods ="http://www.loc.gov/mods/v3";
declare namespace tei ="http://www.tei-c.org/ns/1.0";
declare namespace xi = "http://www.w3.org/2003/XInclude";
declare namespace xlink="http://www.w3.org/1999/xlink";

declare default element namespace "http://www.loc.gov/mods/v3";


declare updating function local:upName($source as node()*, $target as node()*)  {
for $n in $source/mods:name
return
    insert node <namePart lang="chi" transliteration="chinese/ala-lc">{$target/..//mods:namePart/text()}</namePart> into doc(document-uri($n/../..))//mods:name
    
};       


declare updating function local:upTitle($source as node()*, $target as node()*)  {
let $source := doc(document-uri($source/..))/mods:mods
return     
    insert node <titleInfo type="translated" transliteration="chinese/ala-lc">{$target/..//mods:titleInfo/text()}</titleInfo> after $source/../mods:titleInfo
};

declare updating function local:inLang($source as node()*, $target as node()*)  {
    insert node <language>
                <languageTerm type="code" authority="iso639-2b"/>
            </language> before $source/../mods:identifier            
};

declare updating function local:inRecord($source as node()*, $target as node()*)  {
    insert node <recordInfo>
                <recordOrigin>exported from MHDB database</recordOrigin>
            </recordInfo> before $source/../mods:identifier
            };

let $py := doc('file:/Users/halalpha/Documents/gits/german/german/pinyin/merge_py_wenlin2.xml')
let $hz := collection('file:/Users/halalpha/Documents/gits/german/german/books/')

let $source := $hz/mods:mods
let $trans := $py//mods:mods[@ID[. = $source/@ID]]
 


(:for $n in $source/mods:name

return 
doc(document-uri($n/../..))//mods:name:)

(:    local:upName($source, $trans):)
    
    (:Test :)

(:    <new>
        {$trans/..//mods:namePart}
        {$trans/..//mods:titleInfo}
        {$source/..}
    </new>:)
