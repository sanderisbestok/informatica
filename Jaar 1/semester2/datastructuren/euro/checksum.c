// Author:          Sander Hansen
// Name:            checksum.c
// Description:     Checks if the serial number of a euro banknote is valid
// Usage:           make check, with the serial numbers in a document called serials.txt

#include <stdio.h>
#include <stdlib.h>
#include <ctype.h>
#include <error.h>
#include <assert.h>

#include "debug.h"

// Function that will get the right checksum with the given checksum digit
int get_checksum(char c) {
    int checksum[] = {'Z', 9, 'Y', 1, 'X', 2, 'V', 4, 'U', 5, 'T', 6, 'S', 7,
    'P', 1, 'N', 3, 'N', 4, 'L', 5, 'H', 9, 'G', 1, 'F', 2, 'E', 3, 'D', 4};

    for(int i = 0; (unsigned)i < sizeof(checksum); i = i + 2) {
        if(c == checksum[i]){
            return checksum[i + 1];
        }
    }

    //TODO Error handling
    return 4;
}

// Get length of long long
int get_length(long long sum) {
    int length = 0;
    do {
        sum = sum / 10;
        length++;
    } while(sum != 0);

    return length;
}

// Function that will get the digit sum of a given long long
int get_sum(long long num) {
    int length = get_length(num);
    int numbers[length];
    int sum = 0;

    for(int i = 0; i < length; i++) {
        numbers[i] = num % 10;
        num = num / 10;
    }

    for(int i = 0; (unsigned)i < (sizeof(numbers) / sizeof(numbers[0])); i++) {
        sum = sum + numbers[i];
    }

    return sum;
}

// Checks if the digit sum of the serial number plus the ascii value can be divised by 9
int ascii_check(char c, long long num) {
    long long asciiSum = 0;

    asciiSum = c + num;

    if((asciiSum % 9) == 0) {
        return 1;
    } else {
        return 0;
    }
}

// Checks if bankknote is valid by checking if the given checksum is equal to
// the calculated checksum and by the ASCII method
int check_serial(char c, long long num) {
    assert(isupper(c));
    assert(num > 0);

    int checksum = get_checksum(c);
    int asciiCheck = 0;

    num = get_sum(num);
    num = get_sum(num);
    num = get_sum(num);

    asciiCheck = ascii_check(c, num);

    if(num == checksum && asciiCheck){
        return 1;
    } else {
        return 0;
    }
}

int main(void) {
    long long num; // Need 64 bit integer to store 11 digit serial number.
    char c;

    // Example of debug printing
    DEBUG_PRINT(("Start program\n"));

    while (fscanf(stdin, "%c%lld\n", &c, &num) == 2) {
        fprintf(stderr, "%c%lld: ", c, num);

        if (check_serial(c, num)) {
            printf("OK");
        } else {
            printf("FAILED");
        }
        printf("\n");
    }
    return EXIT_SUCCESS;
}
