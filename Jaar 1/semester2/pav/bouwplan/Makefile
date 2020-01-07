TEXNAME=bouwplanTabel
PDFNAME=bouwplan
LATEXC=pdflatex
LATEXARGS=--shell-escape -jobname=$(PDFNAME)
BIBC=bibtex
BIBNAME=bib
VIEWER=evince
RM=rm -rf

all: latex
	$(MAKE) clean

open:
	$(VIEWER) $(PDFNAME).pdf &

latex: $(TEXNAME).tex
	$(LATEXC) $(LATEXARGS) $(TEXNAME).tex
	$(LATEXC) $(LATEXARGS) $(TEXNAME).tex

bib: latex
	$(BIBC) $(PDFNAME).aux
	$(MAKE) latex
	$(MAKE) clean

clean:
	$(RM) $(PDFNAME).bbl
	$(RM) $(PDFNAME).blg
	$(RM) $(PDFNAME).log
	$(RM) $(PDFNAME).aux
	$(RM) $(PDFNAME).pyg
	$(RM) $(PDFNAME).out
	$(RM) $(PDFNAME).toc
	$(RM) texput.log
	$(RM) _minted-$(PDFNAME)

remove: clean
	$(RM) $(PDFNAME).pdf
