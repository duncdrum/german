declare namespace mods ="http://www.loc.gov/mods/v3";
declare namespace tei ="http://www.tei-c.org/ns/1.0";
declare namespace xi = "http://www.w3.org/2003/XInclude";
declare namespace xlink="http://www.w3.org/1999/xlink";

declare default element namespace "http://www.loc.gov/mods/v3";

let $py := doc('file:/Users/halalpha/Documents/gits/german/german/pinyin/merge_py_wenlin2.xml')
let $hz := collection('file:/Users/halalpha/Documents/gits/german/german/books/')



for $source in $hz//mods:mods/@ID,
     $trans in $py//mods:mods/@ID[. = $source]

return (
    insert node <namePart>{$trans/..//mods:namePart/text()}</namePart> into $source/../mods:name, 
    insert node <titleInfo>{$trans/..//mods:titleInfo/text()}</titleInfo> after $source/../mods:titleInfo,
    insert nodes <language>
                <languageTerm type="code" authority="iso639-2b"/>
            </language>
            <recordInfo>
                <recordOrigin>exported from MHDB database</recordOrigin>
            </recordInfo> before $source/../mods:identifier
        )

(:Test :)

(:    <new>
        {$trans/..//mods:namePart}
        {$trans/..//mods:titleInfo}
        {$source/..}
    </new>:)