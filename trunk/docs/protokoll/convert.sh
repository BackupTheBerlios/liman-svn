#!/bin/sh
FINAL="../beleg3/arbeitsaufgaben.tex"
function sedit()
{
	sed  "$1" $TMP1 > $TMP2
	mv $TMP2 $TMP1
}
echo '\chapter{Arbeitsaufgaben}' > $FINAL


for FILE in *.xhtml;
 do 
	TMP1="/tmp/${FILE}1"
	TMP2="/tmp/${FILE}2"
	cp $FILE $TMP1
	sedit 's/<!DOCTYPE.*>//' 
	sedit 's/<[\/]*html.*>//'
	sedit 's/<[\/]*head.*>//' 
	sedit 's/<title.*<\/title>//' 
	sedit 's/<\/title.*>/\}/' 
	sedit 's/<[\/]*meta.*>//' 
	sedit 's/<style.*>.*<\/style>//' 
	sedit 's/<[\/]*body.*>//'
	sedit 's/<[\/]*h1.*>.*<\/h1>//'
	sedit 's/<h2>/\\section\{/'
	sedit 's/<\/h2>/\}/'
	sedit 's/<h3[^>]*>/\\subsection\{/'
	sedit 's/<\/h3>/\}/'
	sedit 's/<ul>/\\begin\{itemize\}/' 
	sedit 's/<\/ul>/\\end\{itemize\}/' 
	sedit 's/<ol>/\\begin\{itemize\}/' 
	sedit 's/<\/ol>/\\end\{itemize\}/' 
	sedit 's/<dl>/\\begin\{itemize\}/' 
	sedit 's/<\/dl>/\\end\{itemize\}/' 
	sedit 's/<li>/\\item /' 
	sedit 's/<\/li>//' 
	sedit 's/<dt>/\\item /' 
	sedit 's/<\/dt>//' 
	sedit 's/<dd>/\:\ /' 
	sedit 's/<\/dd>//' 
	sedit 's/<a [^>]*>//' 
	sedit 's/<\/a>//' 
	# sed only subsitutes once on a line? well, then do it again:
	sedit 's/<a [^>]*>//' 
	sedit 's/<\/a>//' 

	sedit 's/<acronym [^>]*>//' 
	sedit 's/<\/acronym>//' 
	sedit 's/<[\/]*div[^>]*>//'
	#sedit 's/<br[^>]*>/\\\\\n/'
	sedit 's/<br[^>]*>//'
	sedit 's/<p>//'
	#sedit 's/<p>/\\\\\n/'
	sedit 's/<\/p>//'
	sedit 's/<img src=\"/\\includegraphics\[scale=0.8\]\{\.\.\/protokoll\//'
	sedit 's/\" alt=\"Klassenaufteilung\"\ \/>/}/'
	sedit 's/<b>/\{\\em /' 
	sedit 's/<\/b>/}/' 
	sedit 's/<i>/\{\\it /' 
	sedit 's/<\/i>/}/' 
	# sed only subsitutes once on a line? well, then do it again:
	sedit 's/<i>/\{\\it /' 
	sedit 's/<\/i>/}/' 

	sedit 's/\&ouml/\"o/'
	sedit 's/\&auml/\"a/'
	sedit 's/\&uuml/\"u/'
	dos2unix $TMP1

	
	sedit '/^[ \t]*$/d' # remove blanks
	#sedit 's/^[ \t]*//' # remove spaces
	# sedit 's/\\item/\t\\item/' # add some spaces ;)
	cat $TMP1 >> $FINAL
	echo '\newpage' >> $FINAL
	rm $TMP1 
done
echo "converted to $FINAL"
