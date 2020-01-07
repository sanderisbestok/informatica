% LaTeX PAV klasse voor artikelen en generieke documenten
% Onderdeel van het LaTeX template pakket Practicum Academische Vaardigheden

% Voor readme en meest recente versie, zie
% https://gitlab-fnwi.uva.nl/informatica/LaTeX-template.git

% Geschreven door Robert van Wijk, Stephan van Schaik, Willem Vermeulen en 
% Stephen Swatman.

%------------------------------------------------------------------------------
%	PACKAGES
%------------------------------------------------------------------------------

\NeedsTeXFormat{LaTeX2e}
\ProvidesClass{pav}
\LoadClass[10pt]{article}

\RequirePackage{hyperref}
\RequirePackage{attachfile}
\RequirePackage{etoolbox}
\RequirePackage{xparse}
\RequirePackage{pgffor}
\RequirePackage{arrayjobx}
\RequirePackage{graphicx}
\RequirePackage{fancyhdr}
\RequirePackage{lastpage}
\RequirePackage{translations}
\RequirePackage{lipsum}
\RequirePackage{ifthen}
\RequirePackage{wrapfig}
\RequirePackage{xstring}
\RequirePackage[a4paper, left=35mm, right=35mm, top=35mm, bottom=35mm]{geometry}
\RequirePackage[utf8]{inputenc}


%------------------------------------------------------------------------------
%	INSTELLINGEN
%------------------------------------------------------------------------------

\newcommand*{\includesource}{}

\DeclareOption{source}{
    \renewcommand*{\includesource}{\begin{flushright}\attachfile{\jobname.tex}\end{flushright}}
    \attachfilesetup{description=LaTeX code, icon=Tag, mimetype=application/x-tex}
}

\DeclareOption*{\PassOptionsToClass{\CurrentOption}{article}}
\ProcessOptions



\reversemarginpar
%------------------------------------------------------------------------------
%	VERTALINGEN
%------------------------------------------------------------------------------

\DeclareTranslation{dutch}{tutor}{Tutor}
\DeclareTranslation{english}{tutor}{Tutor}

\DeclareTranslation{dutch}{page}{Pagina}
\DeclareTranslation{english}{page}{Page}

\DeclareTranslation{dutch}{of}{van}
\DeclareTranslation{english}{of}{of}

\DeclareTranslation{dutch}{lecturer}{Docent}
\DeclareTranslation{english}{lecturer}{Lecturer}

\DeclareTranslation{dutch}{group}{Practicumgroep}
\DeclareTranslation{english}{group}{Group}

\DeclareTranslation{dutch}{student}{Student}
\DeclareTranslation{english}{student}{Student}

\DeclareTranslation{dutch}{students}{Studenten}
\DeclareTranslation{english}{students}{Students}

\DeclareTranslation{dutch}{course}{Cursus}
\DeclareTranslation{english}{course}{Course}

\DeclareTranslation{dutch}{mentor}{Begeleider}
\DeclareTranslation{english}{mentor}{Mentor}

\DeclareTranslation{dutch}{course_id}{Vakcode}
\DeclareTranslation{english}{course_id}{Course code}

\DeclareTranslation{dutch}{uva_logo}{logoUvA_nl}
\DeclareTranslation{english}{uva_logo}{logoUvA_en}

%------------------------------------------------------------------------------
%	GEGEVENS VERWERKEN
%------------------------------------------------------------------------------

\newcommand*{\assignment}[1]{\gdef\@assignment{#1}}
\newcommand*{\@assignment}{$\backslash assignment\{\}$ is unset}

\newcommand*{\assignmenttype}[1]{\gdef\@assignmenttype{#1}}
\newcommand*{\@assignmenttype}{$\backslash assignmenttype\{\}$ is unset}

\newcommand*{\tutor}[1]{\gdef\@tutor{#1}}
\newcommand*{\@tutor}{}

\newcommand*{\mentor}[1]{\gdef\@mentor{#1}}
\newcommand*{\@mentor}{}

\newcommand*{\group}[1]{\gdef\@group{#1}}
\newcommand*{\@group}{}

\newcommand*{\docent}[1]{\gdef\@docent{#1}}
\newcommand*{\@docent}{}

\newcommand*{\course}[1]{\gdef\@course{#1}}
\newcommand*{\@course}{}

\newcommand*{\courseid}[1]{\gdef\@courseid{#1}}
\newcommand*{\@courseid}{}

\newcounter{authorcount}
\setcounter{authorcount}{0}

\newcounter{uvacount}
\setcounter{uvacount}{0}

\newcommand\setprefix[2]{\expandafter\def\csname#1\endcsname{#2}}
\newcommand\getprefix[1]{\csname#1\endcsname}

\NewDocumentCommand\authors{>{\SplitList{;}}m}{
    \ProcessList{#1}{ \addauthor }
}
\newcommand\addauthor[1]{
    \stepcounter{authorcount}
    \setprefix{author\arabic{authorcount}}{#1}
}
\renewcommand{\author}[1]{
	\addauthor{#1}
}
\NewDocumentCommand\uvanetids{>{\SplitList{;}}m}{
    \ProcessList{#1}{ \adduvanetid }
}
\newcommand\adduvanetid[1]{
    \stepcounter{uvacount}
    \setprefix{uva\arabic{uvacount}}{#1}
}
\newcommand\uvanetid[1]{
	\adduvanetid{#1}
}

%------------------------------------------------------------------------------
%	HEADERS, FOOTERS EN SECTIONS
%------------------------------------------------------------------------------

\pagestyle{fancy}
\lhead{\includegraphics[width=5cm]{\GetTranslation{uva_logo}}}
\rhead{\footnotesize \textsc {\@assignmenttype\\ \@assignment}}
\lfoot
{
\footnotesize
\begin{minipage}{0.8\textwidth}
\foreach \index in {1, ..., \value{authorcount}} {%
    \getprefix{author\index}\ifthenelse{\equal{\index}{\value{authorcount}}}{}{,}
}
\end{minipage}
}
\cfoot{}
\rfoot{\small \textsc {\GetTranslation{page} \thepage\ \GetTranslation{of} \pageref{LastPage}}}
\renewcommand{\footrulewidth}{0.5pt}

\fancypagestyle{firststyle}
 {
  \includesource
  \fancyhf{}
   \renewcommand{\headrulewidth}{0pt}
   \rfoot{\small \textsc {\GetTranslation{page} \thepage\ \GetTranslation{of} \pageref{LastPage}}}
 }

\def\addlines#1{%
  \IfSubStr{#1}{ }{%
  	\saveexpandmode
  	\expandarg
    \StrSubstitute{#1}{ }{\noexpand\\}}{#1}}
    \restoreexpandmode

\newcommand{\subsectionauthor}[2]{
\stepcounter{subsection}
\addcontentsline{toc}{subsection}{\arabic{section}.\arabic{subsection} \hspace{0.3em} #1 {\scriptsize (#2)}}
\large\textbf{\arabic{section}.\arabic{subsection} \hspace{0.3em} #1}
\marginpar{ \footnotesize \textbf{\addlines{#2}}}
\normalsize
}

%------------------------------------------------------------------------------
%	VOORPAGINA
%------------------------------------------------------------------------------

\renewcommand*{\maketitle}{%
\thispagestyle{firststyle}
\begin{center}
\includegraphics[width=7cm]{\GetTranslation{uva_logo}}
\\[1cm]
	\textsc{\Large \@assignment}\\[0.2cm]
		\rule{\linewidth}{0.5pt} \\[0.4cm]
			{ \huge \bfseries \@title}
		\rule{\linewidth}{0.5pt} \\[0.2cm]
	{\large \@date  \\[0.4cm]}

	\begin{minipage}{0.4\textwidth}
		\begin{flushleft}
			\emph{\ifnum\value{authorcount}>1\relax
                    \GetTranslation{students}%
                  \else
                    \GetTranslation{student}%
                  \fi:}\\
			\foreach \index in {1, ..., \value{authorcount}} {%
                {\getprefix{author\index}\\ {\small \getprefix{uva\index}\\[0.2cm]}}
            }
		\end{flushleft}
	\end{minipage}
~
	\begin{minipage}{0.4\textwidth}
		\begin{flushright}
			\ifdefempty{\@tutor}{}{
    			\emph{\GetTranslation{tutor}:} \\
    			\@tutor \\[0.2cm]
			}
			\ifdefempty{\@mentor}{}{
    			\emph{\GetTranslation{mentor}:} \\
    			\@mentor \\[0.2cm]
			}
			\ifdefempty{\@group}{}{
    			\emph{\GetTranslation{group}:} \\
    			\@group \\[0.2cm]
    		}
			\ifdefempty{\@docent}{}{
    			\emph{\GetTranslation{lecturer}:} \\
    			\@docent \\[0.2cm]
    		}
			\ifdefempty{\@course}{}{
    			\emph{\GetTranslation{course}:} \\
    			\@course \\[0.2cm]
    		}
			\ifdefempty{\@courseid}{}{
    			\emph{\GetTranslation{course_id}:} \\
    			\@courseid \\[0.2cm]
			}
		\end{flushright}
	\end{minipage}\\[1 cm]
\end{center}
}
