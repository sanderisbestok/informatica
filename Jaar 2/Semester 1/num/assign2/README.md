Setting up the environment
==========================

For this Python assignment, and any future Python assignments or applications
you may be working on, it is encouraged to set up a virtual environment, in
order to not pollute your system-wide space of packages. Within the virtual
environment, we'll also set up some prerequisites such as `pep8` and `pyflakes`
to check whether the Python files have been properly formatted and don't contain
redundant code. The virtual environment can be set up as follows:

```
sudo apt-get install virtualenv
virtualenv env --python=python3 --system-site-packages
env/bin/pip install pep8 pyflakes
```

Implementation
==============

The framework consists of the following files:

 - `euler_forward.py`: the implementation of the forward Euler method.
 - `filters.py`: this will contain the various filters.
 - `gradient.py`: the application of the different filters.
 - `linefield.py`: the visualisation of a line field.

It is essential that you properly document and annotate your code using
comments.

Report
======

For this assignment you will have to write a report. The general outline of the
report should be as follows:

- An introduction explaining what your report will be covering.
- A thorough explanation of your implementation on an abstract and mathematical
  level. In essence, this should discuss the various filters that have been
  implemented by you, as well as a part on differential equations.
- The results of your experiments.
- A comparison of these results as well as a discussion.
- A conclusion.

Make sure to take good care of both the orthography and grammar. Please, do
proof-read your report several times before you hand it in.

The report should be stored as `docs/report.pdf`, and it must be written in
LaTeX.

Submission
==========

Using the supplied `Makefile` to pack up the assignment into a tarball is
mandatory, as it will ask you for personal information to include within the
assignment, and as it will check your assignment using `pep8` and `pyflakes`,
before it will pack it all up into a tarball. If all went well, the Makefile
will produce a file `assignment1_{student_ids}.tar.gz` that you can then upload
onto Blackboard.
