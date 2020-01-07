DELIVERABLE := assignment2_$(shell ./scripts/get_student_ids.py).tar.gz
DOCS := \
	docs/report.pdf
PYTHON_SOURCES := \
	euler_forward.py \
	filters.py \
	gradient.py \
	linefield.py

all: configure check pack

.config:
	@./scripts/configure.py

configure: .config

AUTHORS: .config
	@./scripts/get_authors.py > AUTHORS

.check: $(PYTHON_SOURCES)
	@pep8 $^
	@pyflakes $^
	@touch $@

check: .check

pack: $(PYTHON_SOURCES) $(DOCS) AUTHORS check
	@tar -czf \
		assignment2_$(shell ./scripts/get_student_ids.py).tar.gz \
		$(PYTHON_SOURCES) $(DOCS) AUTHORS

clean:
	@rm -f .config .check AUTHORS \
		assignment2_$(shell ./scripts/get_student_ids.py).tar.gz

.PHONY: all configure check pack clean
