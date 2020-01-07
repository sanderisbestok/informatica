/* Computer Graphics assignment, Triangle Rasterization
 * Filename ........ trirast.c
 * Description ..... Implements triangle rasterization
 * Created by ...... Paul Melis
 *
 * Student names; Sander Hansen; Nima Motamed
 * Student emails; mail@sanderhansen.nl; nmotamed22@gmail.com
 * Collegekaart; 10995080; 11025352
 * Date; 02-11-2016
 * Comments; ........
 */

#include <stdlib.h>
#include <stdio.h>
#include <math.h>

#include "types.h"

/* Calculate the max value of 3 floats. */
float max(float a, float b, float c) {
  float d;
  d = a > b ? a : b;

  return d > c ? d : c;
}

/* Calculate the min value of 3 floats. */
float min(float a, float b, float c) {
  float d;
  d = a < b ? a : b;

  return d < c ? d : c;
}

/* Calculate line with given vertices. */
float calc_geometric(float x0, float y0, float x1, float y1, float x,
                     float y) {
  return (y0 - y1) * x + (x1 - x0) * y + x0 * y1 - x1 * y0;
}

/*
 * Rasterize a single triangle.
 * The triangle is specified by its corner coordinates
 * (x0,y0), (x1,y1) and (x2,y2).
 * The triangle is drawn in color (r,g,b).
 */
void draw_triangle(float x0, float y0, float x1, float y1, float x2, float y2,
                   byte r, byte g, byte b) {
  float alpha, beta, gamma, minx, maxx, miny, maxy, falpha, fbeta, fgamma, f12,
  f20, f01, edgealpha, edgebeta, edgegamma;

  minx = min(x0, x1, x2);
  maxx = max(x0, x1, x2);
  miny = min(y0, y1, y2);
  maxy = max(y0, y1, y2);

  falpha = calc_geometric(x1, y1, x2, y2, x0, y0);
  fbeta = calc_geometric(x2, y2, x0, y0, x1, y1);
  fgamma = calc_geometric(x0, y0, x1, y1, x2, y2);

  /* Calculations for off-screen point. */
  f12 = calc_geometric(x1, y1, x2, y2, -1, -1);
  f20 = calc_geometric(x2, y2, x0, y0, -1, -1);
  f01 = calc_geometric(x0, y0, x1, y1, -1, -1);

  /* Calculations for checking whether a point is on a triangle edge. */
  edgealpha = falpha * f12;
  edgebeta = fbeta * f20;
  edgegamma = fgamma * f01;

  for (float y = miny; y <=maxy; y++) {
    for (float x = minx; x <= maxx; x++) {
      alpha = calc_geometric(x1, y1, x2, y2, x, y) / falpha;
      beta = calc_geometric(x2, y2, x0, y0, x, y) / fbeta;
      gamma = calc_geometric(x0, y0, x1, y1, x, y) / fgamma;

      if ((alpha >= 0 || (alpha > 0 && edgealpha > 0)) &&
           (beta >= 0 || (beta > 0 && edgebeta > 0)) &&
           (gamma >= 0 || (gamma > 0 && edgegamma > 0))) {
        PutPixel(x, y, r, g, b);
      }
    }
  }
}
/*
 * Rasterize a triangle using an optimalized algorithm.
 * The triangle is specified by its corner coordinates
 * (x0,y0), (x1,y1) and (x2,y2).
 * The triangle is drawn in color (r,g,b).
 */
void draw_triangle_optimized(float x0, float y0, float x1, float y1, float x2,
                             float y2, byte r, byte g, byte b)
{
  float alpha, beta, gamma, minx, maxx, miny, maxy, falpha, fbeta, fgamma, f12,
  f20, f01, edgealpha, edgebeta, edgegamma, alpha_base, beta_base, gamma_base,
  alpha_y_base, beta_y_base, gamma_y_base;
  int in_triangle;

  minx = min(x0, x1, x2);
  maxx = max(x0, x1, x2);
  miny = min(y0, y1, y2);
  maxy = max(y0, y1, y2);

  falpha = calc_geometric(x1, y1, x2, y2, x0, y0);
  fbeta = calc_geometric(x2, y2, x0, y0, x1, y1);
  fgamma = calc_geometric(x0, y0, x1, y1, x2, y2);

  /* Calculations for off-screen point. */
  f12 = calc_geometric(x1, y1, x2, y2, -1, -1);
  f20 = calc_geometric(x2, y2, x0, y0, -1, -1);
  f01 = calc_geometric(x0, y0, x1, y1, -1, -1);

  /* Calculations for checking whether a point is on a triangle edge. */
  edgealpha = falpha * f12;
  edgebeta = fbeta * f20;
  edgegamma = fgamma * f01;

  /* a * 1 / b is much faster than a / b */
  falpha = 1 / falpha;
  fbeta = 1 / fbeta;
  fgamma = 1 / fgamma;

  /* This base is used for every outer loop. */
  alpha_y_base = calc_geometric(x1, y1, x2, y2, minx, miny);
  beta_y_base = calc_geometric(x2, y2, x0, y0, minx, miny);
  gamma_y_base = calc_geometric(x0, y0, x1, y1, minx, miny);

  for (float y = miny; y <= maxy; y++) {
    in_triangle = 0;
    alpha_base = alpha_y_base;
    beta_base = beta_y_base;
    gamma_base = gamma_y_base;
    for (float x = minx; x <= maxx; x++) {
      alpha = alpha_base * falpha;
      beta = beta_base * fbeta;
      gamma = gamma_base * fgamma;

      if ((alpha >= 0 || (alpha > 0 && edgealpha > 0)) &&
           (beta >= 0 || (beta > 0 && edgebeta > 0)) &&
           (gamma >= 0 || (gamma > 0 && edgegamma > 0))) {
        in_triangle = 1;
        PutPixel(x, y, r, g, b);
      }
      else if (in_triangle) {
        break;
      }
      alpha_base += (y1 - y2);
      beta_base += (y2 - y0);
      gamma_base += (y0 - y1);
    }
    alpha_y_base += (x2 - x1);
    beta_y_base += (x0 - x2);
    gamma_y_base += (x1 - x0);
  }
}
