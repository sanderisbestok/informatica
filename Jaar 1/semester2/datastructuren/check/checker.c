/*  Author:         Sander Hansen
    Name:           checker.c
    Description:    Checks if in a chess game a king is in check
    Usage:          ./checker filename.txt
    Comments:       After thinking for a while I chose to check if a king is in
                    check from the Kings perspective. The code may be more
                    difficult to expand (thinking more then one move) but it has
                    to check less of the game board. (It probably wont matter
                    that much but at least I tried to think about it.) */
#include <stdio.h>
#include <stdlib.h>
#include <ctype.h>
#include <error.h>
#include <assert.h>
#include <unistd.h>

#define BSIZE 8
#define pawn_w 'P'
#define pawn_b 'p'
#define knight_w 'N'
#define knight_b 'n'
#define bishop_w 'B'
#define bishop_b 'b'
#define rook_w 'R'
#define rook_b 'r'
#define queen_w 'Q'
#define queen_b 'q'
#define king_w 'K'
#define king_b 'k'
#define empty '.'

const int north[2] = {0, -1};
const int northeast[2] = {1, -1};
const int east[2] = {1, 0};
const int southeast[2] = {1, 1};
const int south[2] = {0, 1};
const int southwest[2] = {1, -1};
const int west[2] = {-1, 0};
const int northwest[2] = {-1, -1};
const int horses[16] = {2, 1, 2, -1, -2, 1, -2, -1, 1, 2, 1, -2, -1, 2, -1, -2};

struct Coord {
    int x;
    int y;
    int is_white;
};

/* Function that will check if a file is given within the commandline and
   if the file which is given does exist. */
int check_input(int argc, char **argv) {
    if (argc < 2) {
        printf("Please add a filename to the commandline\n");
        return 1;
    } else if (access(argv[1], F_OK) == -1) {
        printf("The file you entered does not exist\n");
        return 1;
    } else {
        return 0;
    }
}

/* Function will read the board from given filename*/
void read_board(char board[BSIZE][BSIZE], struct Coord *king_w_coord,
struct Coord *king_b_coord, char **argv) {
    char input;

    FILE * fp = fopen (argv[1], "r");

    /* Fill the array with elements of the board*/
    for (int i = 0; i < BSIZE; i++) {
        for (int j = 0; j <= BSIZE; j++) {
            input = getc(fp);

            /* Set coord of the white and black king*/
            if (input == king_w) {
                (*king_w_coord).y = i;
                (*king_w_coord).x = j;
                (*king_w_coord).is_white = 1;
            } else if (input == king_b) {
                (*king_b_coord).y = i;
                (*king_b_coord).x = j;
                (*king_b_coord).is_white = 0;
            }

            if (input != '\n') {
                board[i][j] = input;
            }
        }
    }
}

/* Function that will print the board, for testing purposes */
void print_board(char board[BSIZE][BSIZE]) {

    for (int i = 0; i < BSIZE; i++) {
        printf("---------------------------------\n");
        printf("|");
        for (int j = 0; j < BSIZE; j++) {
            printf(" %c ", board[i][j]);
            printf("|");
        }
        printf("\n");
    }
    printf("---------------------------------\n");
}

/* Function that will check if the rook queen or bishop is found, if nothing
   has been found and the end of the board is reached it will return 0;*/
int check_rook_queen_bishop(char board[BSIZE][BSIZE], struct Coord *king_coord,
int is_white, const int direction[2]) {
    int x = (*king_coord).x;
    int y = (*king_coord).y;
    /* Keep checking until either a pion has been found or if the next move will
       be outside the board. This proces has to continue until something is
       found that's why while(1) is used. Once a condition is true (which will)
       always be reached at one point it will return. */
    while(1) {
        x = x + direction[0];
        y = y + direction[1];
        if ((is_white && (board[y][x] == queen_b))
        || (!is_white && (board[y][x] == queen_w))) {
            return 1;
        } else if (direction == north || direction == east
        || direction == south || direction == west) {
            if ((is_white && (board[y][x] == rook_b))
            || (!is_white && (board[y][x] == rook_w))) {
                return 1;
            }
        } else if (direction == northeast || direction == southeast
        || direction == southwest || direction == northwest) {
            if ((is_white && (board[y][x] == bishop_b))
            || (!is_white && (board[y][x] == bishop_w))) {
                return 1;
            }
        }

        /* Check if the next check is not out of bounds. If so, the control will
           stop This way their will be no control out of the array index. */
        if (board[y][x] != empty || (y + direction[1]) > BSIZE
        || (y + direction[1]) < 0 || (x + direction[0]) > BSIZE
        || (x + direction[0]) < 0) {
            return 0;
        }
    }
}

/* This function can check of any given direction if there is a pion, it will
   return if the pion which is found can check the king */
int check_direction(char board[BSIZE][BSIZE], struct Coord *king_coord,
int is_white, const int direction[2]) {
    int x = (*king_coord).x;
    int y = (*king_coord).y;

    /* Initial check if index will not be checked out of bounds if so, return
       with 0 */
    if ((y + direction[1]) > BSIZE || (y + direction[1]) < 0
    || (x + direction[0]) > BSIZE || (x + direction[0]) < 0) {
        return 0;
    /* Check for pawns */
    } else if (is_white && (direction == northeast || direction == northwest)
    && (board[y+direction[1]][x+direction[0]] == pawn_b)) {
        return 1;
    } else if (!is_white && (direction == southeast || direction == southwest)
    && (board[y+direction[1]][x+direction[0]] == pawn_w)) {
        return 1;
    }

    /* If nothing has been found check for rook queen bishop in function*/
    return check_rook_queen_bishop(board, king_coord, is_white, direction);
}

/* This function will check if the king can be hit by the horses if so it will
   return 1 if not 0 */
int check_horses(char board[BSIZE][BSIZE], struct Coord *king_coord,
int is_white) {
    int x, y;

    /* There are 8 possible positions for the horses, which are saved in a
    constant. This forloop will check all the positions. */
    for (int i = 0; i < 16; i += 2 ) {
        x = (*king_coord).x + horses[i];
        y = (*king_coord).y + horses[i+1];

        if (y < BSIZE || y > 0 || x < BSIZE || x > 0) {
            if ((is_white && (board[y][x] == knight_b)) || (!is_white
            && (board[y][x] == knight_w))) {
                return 1;
            }
        }
    }

    return 0;
}

/* Function that will call of the functions to check the different dirrections
 * returns 1 if a king is in check, 0 if not. */
int check_king(char board[BSIZE][BSIZE], struct Coord *king_coord) {
    int check = 0;

    check = ((check_direction(board, king_coord, (*king_coord).is_white, north))
    || (check_direction(board, king_coord, (*king_coord).is_white, east))
    || (check_direction(board, king_coord, (*king_coord).is_white, south))
    || (check_direction(board, king_coord, (*king_coord).is_white, west))
    || (check_direction(board, king_coord, (*king_coord).is_white, northeast))
    || (check_direction(board, king_coord, (*king_coord).is_white, southeast))
    || (check_direction(board, king_coord, (*king_coord).is_white, southwest))
    || (check_direction(board, king_coord, (*king_coord).is_white, northwest))
    || (check_horses(board, king_coord, (*king_coord).is_white)));

    return check;
}

/* The main function will call all the functions and will print the output
   about which king is in check */
int main(int argc, char **argv) {
    char board[BSIZE][BSIZE];
    struct Coord king_w_coord, king_b_coord;
    int check_w = 0, check_b = 0;

    if (check_input(argc, argv)) {
        return EXIT_SUCCESS;
    }

    read_board(board, &king_w_coord, &king_b_coord, argv);
    print_board(board);

    check_w = check_king(board, &king_w_coord);
    check_b = check_king(board, &king_b_coord);

    if (check_w) {
        printf("\nWhite king is in check \n");
        return EXIT_SUCCESS;

    } else if (check_b) {
        printf("\nBlack king is in check \n");
        return EXIT_SUCCESS;
    } else {
        printf("\nNo king is in check \n");
        return EXIT_SUCCESS;
    }
}
