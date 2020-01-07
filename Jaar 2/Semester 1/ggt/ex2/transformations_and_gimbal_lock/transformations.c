/* Computer Graphics, Assignment 4, Transformations and Gimbal Lock
 *
 * Student name .... Sander Hansen; Nima Motamed
 * Student email ... mail@sanderhansen.nl; nmotamed22@gmail.com
 * Collegekaart .... 10995080; 11025352
 * Date ............ 11-11-2016
 *
 */
#include <stdio.h>
#include <stdlib.h>
#include <math.h>
#include <GL/gl.h>
#include "transformations.h"

/* ANSI C/ISO C89 does not specify this constant (?) */
#ifndef M_PI
#define M_PI           3.14159265358979323846  /* pi */
#endif

/* Calculate the min value of 3 floats. */
float min(GLfloat a, GLfloat b, GLfloat c) {
  GLfloat d;
  d = a < b ? a : b;

  return d < c ? d : c;
}

/* Scale with a scale matrix */
void myScalef(GLfloat x, GLfloat y, GLfloat z)
{
    GLfloat M[16] =
    {
        x, 0.0, 0.0, 0.0,
        0.0, y, 0.0, 0.0,
        0.0, 0.0, z, 0.0,
        0.0, 0.0, 0.0, 1.0
    };

    glMultMatrixf(M);
}

/* Translate with a translation matrix */
void myTranslatef(GLfloat x, GLfloat y, GLfloat z)
{
    GLfloat M[16] =
    {
        1.0, 0.0, 0.0, 0.0,
        0.0, 1.0, 0.0, 0.0,
        0.0, 0.0, 1.0, 0.0,
        x, y, z, 1.0
    };

    glMultMatrixf(M);
}

/* Rotate with a rotation matrix */
void myRotatef(GLfloat angle, GLfloat x, GLfloat y, GLfloat z)
{
    GLfloat u[3], v[3], w[3], t[3];
    GLfloat length, lowest, radian;

    /* Normalize w */
    length = sqrt(x * x + y * y + z * z);

    w[0] = x / length;
    w[1] = y / length;
    w[2] = z / length;

    /* Create a temp vector by making the lowest value of w 1 */
    lowest = min(w[0], w[1], w[2]);

    for (int i = 0; i < 3; i++) {
        if (w[i] == lowest) {
            t[i] = 1;
        } else {
            t[i] = w[i];
        }
    }

    /* t X w */
    u[0] = t[1] * w[2] - w[1] * t[2];
    u[1] = t[2] * w[0] - w[2] * t[0];
    u[2] = t[0] * w[1] - w[0] * t[1];

    /* Normalize u */
    length = sqrt(u[0] * u[0] + u[1] * u[1] + u[2] * u[2]);

    u[0] = u[0] / length;
    u[1] = u[1] / length;
    u[2] = u[2] / length;

    /* w X u*/
    v[0] = w[1] * u[2] - u[1] * w[2];
    v[1] = w[2] * u[0] - u[2] * w[0];
    v[2] = w[0] * u[1] - u[0] * w[1];


    /* u v w form a orthonormal basis */


    /* Make three matrices for the rotation */
    GLfloat A[16] =
    {
        u[0], u[1], u[2], 0.0,
        v[0], v[1], v[2], 0.0,
        w[0], w[1], w[2], 0.0,
        0.0, 0.0, 0.0, 1.0
    };

    /* Angles to radians */
    radian = angle * (M_PI / 180);

    GLfloat B[16] =
    {
        cos(radian), sin(radian), 0.0, 0.0,
        -sin(radian), cos(radian), 0.0, 0.0,
        0.0, 0.0, 1.0, 0.0,
        0.0, 0.0, 0.0, 1.0
    };

    GLfloat C[16] =
    {
        u[0], v[0], w[0], 0.0,
        u[1], v[1], w[1], 0.0,
        u[2], v[2], w[2], 0.0,
        0.0, 0.0, 0.0, 1.0
    };

    glMultMatrixf(A);
    glMultMatrixf(B);
    glMultMatrixf(C);
}
