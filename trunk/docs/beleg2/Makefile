MAIN = teilbeleg2
DEPENDS =	Makefile\
		teilbeleg2.tex\
		doxygen/classBibTeX.tex\
		meta.tex\
		titel.tex

# Standard pdf
all: pdf

# make pdf
pdf: $(MAIN).pdf

# make pdfthumb
pdfthumb: $(MAIN).tpt

# make ps
ps : $(MAIN).ps

# make dvi
dvi: $(MAIN).dvi

# Erzeuge pdf
$(MAIN).pdf: $(DEPENDS)
	pdflatex $(MAIN).tex

# Erzeuge pdfthumb
$(MAIN).tpt: $(DEPENDS) $(MAIN).pdf
	thumbpdf $(MAIN).pdf

# Erzeuge ps aus dvi
$(MAIN).ps: $(MAIN).dvi
	dvips -o $(MAIN).ps -Pcmz -Pamz $(MAIN).dvi

# Erzeuge dvi
$(MAIN).dvi: $(DEPENDS)
	latex $(MAIN)

clean:
	@rm -f *.aux
	@rm -f *.dvi
	@rm -f *.log
	@rm -f *.out
	@rm -f *.toc
	@rm -f *.backup
	@rm -f $(MAIN).pdf
	@rm -f $(MAIN).tpt # pdfthumb
	@rm -f $(MAIN).ps
	@rm -f $(MAIN).dvi
