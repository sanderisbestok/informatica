/* Computer Graphics, Assignment 5, Orthogonal projection
 *
 * Student name .... Sander Hansen; Nima Motamed
 * Student email ... mail@sanderhansen.nl; nmotamed22@gmail.com
 * Collegekaart .... 10995080; 11025352
 * Date ............ 11-11-2016
 *
 */
#include <GL/glut.h>
#include <GL/gl.h>
#include <GL/glu.h>


#define sqr(x) ((x)*(x))

/* ANSI C/ISO C89 does not specify this constant (?) */
#ifndef M_PI
#define M_PI           3.14159265358979323846  /* pi */
#endif

void myOrtho(GLdouble left,
             GLdouble right,
             GLdouble bottom,
             GLdouble top,
             GLdouble near,
             GLdouble far) {

    GLdouble M[16] = {
        2 / (right - left), 0, 0, -(right + left) / (right - left),
        0, 2 / (top - bottom), 0, -(top + bottom) / (top - bottom),
        0, 0, -2 / (far - near), -(far + near) / (far - near),
        0, 0, 0, 1
    };

    glMultMatrixd(M);
}
