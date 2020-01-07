#! /bin/bash


## Output a pseudo-random distribution of resources
# $1: the total number of resource characters to output
# $2...: all possible resource characters
random_resources() {
  local capacity=$1
  shift

  # We output $capacity characters one by one and randomly change to the next
  # possible resource character.
  while (( capacity )); do
    # This is a (biased) criterion to settle the 'bars' of Theorem two in
    # https://en.wikipedia.org/wiki/Stars_and_bars_(combinatorics)
    while (( RANDOM % (capacity + 1)**($# - 1) >= capacity**($# - 1) )); do
      # Move to the next resource character and end the current line of output
      shift
      echo
    done
    # Output the character and update $capacity to reflect the remaining output
    echo -n "$1"
    (( --capacity ))
  done
  echo
}


# Suppress empty lines using an inverted grep match
random_resources 16 {a..d} | grep -v '^$'

