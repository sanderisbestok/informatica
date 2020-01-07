/* Computer Graphics, Assignment 4, Positioning the camera
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
#include <math.h>


/* ANSI C/ISO C89 does not specify this constant (?) */
#ifndef M_PI
#define M_PI           3.14159265358979323846  /* pi */
#endif

void myLookAt(GLdouble eyeX, GLdouble eyeY, GLdouble eyeZ,
              GLdouble centerX, GLdouble centerY, GLdouble centerZ,
              GLdouble upX, GLdouble upY, GLdouble upZ) {
    GLfloat cz[3], cx[3], cy[3], length;


    /* Vector looking from camera to the point of interest */
    cz[0] = centerX - eyeX;
    cz[1] = centerY - eyeY;
    cz[2] = centerZ - eyeZ;

    /* Normalize cz */
    length = sqrt(cz[0] * cz[0] + cz[1] * cz[1] + cz[2] * cz[2]);

    cz[0] = cz[0] / length;
    cz[1] = cz[1] / length;
    cz[2] = cz[2] / length;

    /* up X cz */
    cx[0] = cz[1] * upZ - upY * cz[2];
    cx[1] = cz[2] * upX - upZ * cz[0];
    cx[2] = cz[0] * upY - upX * cz[1];

    /* Normalize cx */
    length = sqrt(cx[0] * cx[0] + cx[1] * cx[1] + cx[2] * cx[2]);

    cx[0] = cx[0] / length;
    cx[1] = cx[1] / length;
    cx[2] = cx[2] / length;

    /* cx X cz */
    cy[0] = cx[1] * cz[2] - cz[1] * cx[2];
    cy[1] = cx[2] * cz[0] - cz[2] * cx[0];
    cy[2] = cx[0] * cz[1] - cz[0] * cx[1];


    GLfloat RT[16] =
    {
        cx[0], cy[0], -cz[0],0,
        cx[1], cy[1], -cz[1],0,
        cx[2], cy[2], -cz[2],0,
        0,0,0,1
    };

    glMultMatrixf(RT);

    /* Translation, in such a way that everything would appear on the
     * right position relative tot the camera */
    glTranslatef(-eyeX, -eyeY, -eyeZ);
}
