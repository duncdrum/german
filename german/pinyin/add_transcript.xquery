declare namespace mods ="http://www.loc.gov/mods/v3";
declare namespace tei ="http://www.tei-c.org/ns/1.0";
declare namespace xi = "http://www.w3.org/2003/XInclude";
declare namespace xlink="http://www.w3.org/1999/xlink";

declare default element namespace "http://www.loc.gov/mods/v3";

let $py := doc('file:/Users/halalpha/Documents/gits/german/german/pinyin/merge_py_wenlin2.xml')
let $hz := collection('file:/Users/halalpha/Documents/gits/german/german/books/')



for $source in $hz//mods:mods/@ID,
     $trans in $py//mods:mods/@ID[. = $source]

return 

update insert 
    <namePart>{$trans/..//mods:namePart}</namePart> into $source/../mods:name 
    <titleInfo>{$trans/..//mods:titleInfo}</titleInfo> following $source/../mods:titleInfo
     <language>
        <languageTerm type="code" authority="iso639-2b"/>
    </language>
    <recordInfo>
        <recordOrigin>exported from MHDB database</recordOrigin>
    </recordInfo> preceding $source/../mods:identifier

(:Test :)

(:    <new>
        {$trans/..//mods:namePart}
        {$trans/..//mods:titleInfo}
        {$source/..}
    </new>:)