#!/usr/bin/python3
import fileinput
import sys

def main():
    answers = []

    amount, solution = list(input().split())
    for i in range(int(amount)):
        answers.append(input())

    length = len(answers[0])

    for answer in answers:
        grading = get_grading(answer, solution)
        grading_points = len(str(grading))

        print(str(grading_points) + " " + str(grading))


def get_grading(answer, solution):
    array = []
    length_answer = len(answer)
    length_solution = len(solution)

    # Fill the array with 0's
    for x in range(length_answer + 1):
        temp_array = []
        for y in range(length_solution + 1):
            temp_array.append(0)
        array.append(temp_array)

    for x in range(length_answer + 1):
        for y in range(length_solution + 1):
            # Skip the first row and column for explicit checking
            if x == 0 or y == 0:
                pass
            elif answer[x - 1] == solution[y - 1]:
                array[x][y] = (array[x - 1][y - 1] * 10 + int(answer[x - 1]))
            # If there are two string of the same length select the one with
            # the lowest value
            elif len(str(array[x][y - 1])) == len(str(array[x - 1][y])) and \
                         array[x][y - 1] > 0 and array[x - 1][y] > 0:
                array[x][y] = min(int(array[x][y - 1]), int(array[x - 1][y]))
            else:
                array[x][y] = max(array[x - 1][y], array[x][y - 1])

    return array[length_answer][length_solution]


if __name__ == "__main__":
    main()
