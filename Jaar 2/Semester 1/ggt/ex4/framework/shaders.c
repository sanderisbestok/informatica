/* Computer Graphics and Game Technology, Assignment Ray-tracing
 *
 * Student name .... Sander Hansen; Nima Motamed
 * Student email ... mail@sanderhansen.nl; nmotamed22@gmail.com
 * Collegekaart .... 10995080; 11025352
 * Date ............ 02-12-2016
 */

#include <math.h>
#include <stdio.h>
#include <stdlib.h>
#include "shaders.h"
#include "perlin.h"
#include "v3math.h"
#include "intersection.h"
#include "scene.h"
#include "quat.h"
#include "constants.h"

/* shade_constant()
 *
 * Always return the same color. This shader does no real computations
 * based on normal, light position, etc. As such, it merely creates
 * a "silhouette" of an object.
 */
vec3 shade_constant(intersection_point ip) {
    return v3_create(1, 0, 0);
}

/* A shader that returns the color of a surface based on the amount of light
 * reaching that point. */
vec3 shade_matte(intersection_point ip) {
    vec3 light_src;
    float c = scene_ambient_light;

    /* For every light source calculate the contribution of the light and add
     * this to to the final light */
    for (int i = 0; i < scene_num_lights; i++) {
        /* Get the vector pointing to the light source */
        light_src = v3_normalize(v3_subtract(scene_lights[i].position, ip.p));

        if (!shadow_check(v3_add(ip.p, v3_multiply(light_src, 0.0001)), light_src)) {
            /* If dot prodcut of the surface normal and vector pointing to the
             * light is less then zero. Set it to 0 (It's on the back of the
             * surface so it shouldn't be displayed) */
            c += scene_lights[i].intensity * fmax(0, (v3_dotprod(light_src, ip.n)));
        }
    }

    /* If the color value is bigger then one, set it to one */
    if (c > 1) {
        c = 1;
    }
    return v3_create(c, c, c);
}

/* A shader that returns the color of a surface based on three components:
 * ambient, diffuse and specular intensities.
 */
vec3 shade_blinn_phong(intersection_point ip) {
    vec3 c_dif = v3_create(1, 0, 0), c_spec = v3_create(1, 1, 1), light_src, halfway;
    float k_dif = 0.8, k_spec = 0.5, dif = 0, spec = 0, phong;
    int alpha = 50;

    for (int i = 0; i < scene_num_lights; i++) {
        light_src = v3_normalize(v3_subtract(scene_lights[i].position, ip.p));
        halfway = v3_normalize(v3_add(light_src, ip.i));

        if (!shadow_check(v3_add(ip.p, v3_multiply(light_src, 0.0001)), light_src)) {
            dif += scene_lights[i].intensity * fmax(0, (v3_dotprod(light_src, ip.n)));
        }

        if (!shadow_check(v3_add(ip.p, v3_multiply(halfway, 0.0001)), halfway)) {
            phong = fmax(0, v3_dotprod(light_src, ip.n));
            spec += scene_lights[i].intensity * pow(phong, alpha);
        }
    }
    dif = scene_ambient_light + (k_dif * dif);
    spec = k_spec * spec;
    return v3_add(v3_multiply(c_dif, dif), v3_multiply(c_spec, spec));
}

/* A shader that returns the color of a surface based on the matte color of
 * the surface, and the color reflected from the surface.
 */
vec3 shade_reflection(intersection_point ip) {
    vec3 reflected, c_matte, c_refl;
    float matte_factor = 0.75, refl_factor = 1 - matte_factor;

    reflected = v3_subtract(v3_multiply(ip.n, 2 * v3_dotprod(ip.i, ip.n)), ip.i);
    c_matte = shade_matte(ip);
    c_refl = ray_color(ip.ray_level + 1,
                       v3_add(ip.p, v3_multiply(ip.p, 0.0001)),
                       reflected);

    return v3_add(v3_multiply(c_matte, matte_factor),
                  v3_multiply(c_refl, refl_factor));
}

/* Returns the shaded color for the given point to shade.
 * Calls the relevant shading function based on the material index. */
vec3 shade(intersection_point ip) {
  switch (ip.material) {
    case 0:
      return shade_constant(ip);
    case 1:
      return shade_matte(ip);
    case 2:
      return shade_blinn_phong(ip);
    case 3:
      return shade_reflection(ip);
    default:
      return shade_constant(ip);

    }
}

/*    Determine the surface color for the first object intersected by
 *    the given ray, or return the scene background color when no
 *    intersection is found */
vec3 ray_color(int level, vec3 ray_origin, vec3 ray_direction) {
    intersection_point  ip;

    /*    If this ray has been reflected too many times, simply
     *    return the background color. */
    if (level >= 3)
        return scene_background_color;

    /* Check if the ray intersects anything in the scene */
    if (find_first_intersection(&ip, ray_origin, ray_direction))
    {
        /* Shade the found intersection point */
        ip.ray_level = level;
        return shade(ip);
    }

    /* Nothing was hit, return background color */
    return scene_background_color;
}
