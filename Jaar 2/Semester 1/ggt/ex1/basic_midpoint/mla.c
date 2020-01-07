/* Computer Graphics, Assignment 1, Bresenham's Midpoint Line-Algorithm
 *
 * Filename ........ mla.c
 * Description ..... Midpoint Line Algorithm
 * Created by ...... Jurgen Sturm
 *
 * Student name Sander Hansen; Nima Motamed
 * Student email mail@sanderhansen.nl; nmotamed22@gmail.com
 * Collegekaart 10995080; 11025352
 * Date 02-11-2016
 * Comments: The mla function can be called with the coordinates of to points,
 * it will then draw a line between those two points. With the help of the
 * calculateMidpoint function.
 */

#include "SDL.h"
#include "init.h"

/* This function will determine in which octant the line is */
void mla(SDL_Surface *s, int x0, int y0, int x1, int y1, Uint32 colour) {
  float deltax, deltay, rc;

  /* Calculate slope */
  deltax = x1 - x0;
  deltay = y1 - y0;

  rc = deltay / deltax;

  /* Determine in which quadrant the line will be. After this is determined
   * we will call the calculate function with the correct swapped coordinate
   * system. This way we can treat it like it is in the first octant */
  if (y0 >= y1 && rc <= 0 && rc > -1 && x0 < x1) {
    calculateMidpoint(0, x0, y0, x1, y1, s, colour);
  } else if (y0 > y1 && rc <= -1) {
    calculateMidpoint(1, y1, x1, y0, x0, s, colour);
  } else if (y0 > y1 && rc >= 1) {
    calculateMidpoint(2, y1, (x1 * -1), y0, (x0 * -1), s, colour);
  } else if (y0 > y1 && rc < 1 && rc > 0) {
    calculateMidpoint(3, (x0 * -1), y0, (x1 * -1), y1, s, colour);
  } else if (y1 >= y0 && rc > -1 && rc <= 0) {
    calculateMidpoint(4, (x0 * -1), (y0 * -1), (x1 * -1), (y1 * -1), s, colour);
  } else if (y1 > y0 && rc <= -1) {
    calculateMidpoint(5, (y1 * -1), (x1 * -1), (y0 * -1), (x0 * -1), s, colour);
  } else if (y1 > y0 && rc >= 1) {
    calculateMidpoint(6, (y1 * -1), x1, (y0 * -1), x0, s, colour);
  } else if (y1 > y0 && rc < 1 && rc > 0) {
    calculateMidpoint(7, x0, (y0 * -1), x1, (y1 * -1), s, colour);
  }

  return;
}

/* This function will calculate where the pixel will be drawn, it will do this
 * with the so called (incremental) midpoint algorithm. */
void calculateMidpoint(int octant, int x0, int y0, int x1, int y1,
                       SDL_Surface *s, Uint32 colour) {
  int d, x, y;
  y = y0;

  /* Initial calculation of the determination variable */
  d = ((y0 - y1) * (x0 + 1)) + ((x1 - x0) * (y0 + 0.5)) + (x0 * y1) - (x1 * y0);

  /* Itterate over every x and print the pixels. For each octant the coordinate
   * system will be swapped back so it prints the line correctly. */
  for(x = x0; x != x1; x = x + 1) {
    if (octant == 0) {
      PutPixel(s,x,y,colour);
    } else if (octant == 1) {
      PutPixel(s,y,x,colour);
    } else if (octant == 2) {
      PutPixel(s,(-1 * y),x,colour);
    } else if (octant == 3) {
      PutPixel(s,(-1 * x),y,colour);
    } else if (octant == 4) {
      PutPixel(s,(-1 * x),(-1 * y),colour);
    } else if (octant == 5) {
      PutPixel(s,(-1 * y),(-1 * x),colour);
    } else if (octant == 6) {
      PutPixel(s,y,(-1 * x),colour);
    } else if (octant == 7) {
      PutPixel(s,x,(y * -1),colour);
    }

    /* Use the determination variable to determine if we need to lower the y
     * coordinate. After that calculate the new D based on the old D */
    if (d < 0) {
      y = y - 1;
      d = d + (x1 - x0) + -1 * (y0 - y1);
    } else {
      d = d + -1 * (y0 - y1);
    }
  }

  return;
}
