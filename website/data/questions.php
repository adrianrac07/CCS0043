<?php
/**
 * questions.php
 * ------------------------------------------------------------
 * Quiz question bank.
 * These are ALL taken from the original course files (word
 * problems / practice items) and reformatted into multiple
 * choice so the website can auto-grade them. The numbers and
 * meaning are unchanged from the source material.
 *
 * Each question is an associative array with:
 *   module      -> which module it belongs to (for the label)
 *   question    -> the question text
 *   options     -> 4 possible answers (A-D)
 *   correct     -> index (0-3) of the correct option
 *   explanation -> short worked solution shown after the quiz
 * ------------------------------------------------------------
 */

$questions = [

    [
        "module" => "Module 1: Vectors",
        "question" => "Find the magnitude of the vector <3, 5, 2>.",
        "options" => ["6.16", "5.83", "7.07", "4.24"],
        "correct" => 0,
        "explanation" => "|A| = &radic;(3&sup2;+5&sup2;+2&sup2;) = &radic;(9+25+4) = &radic;38 &asymp; 6.16"
    ],
    [
        "module" => "Module 1: Vectors",
        "question" => "What is the angle of inclination of the vector <5, 0>?",
        "options" => ["90&deg;", "45&deg;", "0&deg;", "180&deg;"],
        "correct" => 2,
        "explanation" => "&theta; = tan&#8315;&sup1;(0/5) = tan&#8315;&sup1;(0) = 0&deg; &mdash; the vector points exactly along the +x axis."
    ],
    [
        "module" => "Module 1: Vectors",
        "question" => "Find the unit vector in the same direction as F = <3, -4>.",
        "options" => ["<0.6, -0.8>", "<3, -4>", "<0.8, -0.6>", "<1.5, -2>"],
        "correct" => 0,
        "explanation" => "|F| = &radic;(3&sup2;+(-4)&sup2;) = &radic;25 = 5. u = F/|F| = <3/5, -4/5> = <0.6, -0.8>"
    ],

    [
        "module" => "Module 2: Operations on Vectors",
        "question" => "Find the dot product of A = 2i - 2j - 3k and B = -11i - 2j + 5k.",
        "options" => ["-33", "33", "-15", "4"],
        "correct" => 0,
        "explanation" => "A&middot;B = (2)(-11) + (-2)(-2) + (-3)(5) = -22 + 4 - 15 = -33 (a scalar)."
    ],
    [
        "module" => "Module 2: Operations on Vectors",
        "question" => "A mountain expedition: Camp A is 11,200 m east and 3,200 m above base camp. Camp B is 8,400 m east and 1,700 m higher than Camp A. What is the approximate magnitude of the displacement between base camp and Camp B?",
        "options" => ["&asymp; 20,203 m", "&asymp; 19,600 m", "&asymp; 4,900 m", "&asymp; 24,500 m"],
        "correct" => 0,
        "explanation" => "Total east = 11,200+8,400 = 19,600 m. Total up = 3,200+1,700 = 4,900 m. Magnitude = &radic;(19,600&sup2;+4,900&sup2;) &asymp; 20,203 m."
    ],

    [
        "module" => "Module 3: Motion in 1D",
        "question" => "Summer jogs with an initial velocity of 4 m/s, then accelerates at 2 m/s&sup2; for 3 seconds. How fast is she running now?",
        "options" => ["10 m/s", "6 m/s", "8 m/s", "12 m/s"],
        "correct" => 0,
        "explanation" => "vf = v0 + at = 4 + (2)(3) = 10 m/s."
    ],
    [
        "module" => "Module 3: Motion in 1D",
        "question" => "Quicksilver drops a phone from a window 8.75 m above the ground. About how long does it take to reach the ground? (g = 9.8 m/s&sup2;)",
        "options" => ["&asymp; 1.34 s", "&asymp; 0.89 s", "&asymp; 1.79 s", "&asymp; 2.45 s"],
        "correct" => 0,
        "explanation" => "&Delta;y = &frac12;gt&sup2; &rarr; 8.75 = &frac12;(9.8)t&sup2; &rarr; t&sup2; = 1.786 &rarr; t &asymp; 1.34 s."
    ],
    [
        "module" => "Module 3: Motion in 1D",
        "question" => "A car starts at rest at x=0. After 2 s it's at 6 miles east. Then, at t=6s, it's at 2 miles (i.e. it went 4 miles back west). What is the car's total DISTANCE traveled?",
        "options" => ["10 miles", "2 miles", "6 miles", "4 miles"],
        "correct" => 0,
        "explanation" => "Distance is the total ground covered: 6 miles (east) + 4 miles (west) = 10 miles, regardless of direction."
    ],

    [
        "module" => "Module 4: Motion in 2D",
        "question" => "In projectile motion, what is the horizontal acceleration (ax) of the object?",
        "options" => ["0", "9.8 m/s&sup2;", "-9.8 m/s&sup2;", "It depends on the launch angle"],
        "correct" => 0,
        "explanation" => "In projectile motion, ax = 0 always (only gravity acts, and gravity is purely vertical), so horizontal velocity stays constant."
    ],
    [
        "module" => "Module 4: Motion in 2D",
        "question" => "What provides the centripetal force for a car turning on a level road?",
        "options" => ["Friction between tires and road", "Gravity", "The engine's horsepower", "Air resistance"],
        "correct" => 0,
        "explanation" => "As stated in the module, friction acting on the turned wheels provides the centripetal force required for circular motion."
    ],

    [
        "module" => "Module 5: Newton's Laws",
        "question" => "A net force of 15 N causes an encyclopedia to accelerate at 5 m/s&sup2;. What is its mass?",
        "options" => ["3 kg", "5 kg", "15 kg", "75 kg"],
        "correct" => 0,
        "explanation" => "F = ma &rarr; m = F/a = 15/5 = 3 kg."
    ],
    [
        "module" => "Module 5: Newton's Laws",
        "question" => "A sled accelerates at 2 m/s&sup2;. If the net force is tripled AND the mass is doubled, what is the new acceleration?",
        "options" => ["3 m/s&sup2;", "2 m/s&sup2;", "6 m/s&sup2;", "1.5 m/s&sup2;"],
        "correct" => 0,
        "explanation" => "New a = (3F)/(2m) = 1.5 &times; (F/m) = 1.5 &times; 2 = 3 m/s&sup2;."
    ],
    [
        "module" => "Module 5: Newton's Laws",
        "question" => "According to Newton's 3rd Law, if object A pushes on object B, what happens?",
        "options" => [
            "B pushes back on A with equal force, opposite direction",
            "B pushes back on A with equal force, same direction",
            "B does not exert any force on A",
            "B exerts a smaller force back on A"
        ],
        "correct" => 0,
        "explanation" => "\"For every action, there is an equal and opposite reaction\" &mdash; the reaction force is equal in size and opposite in direction, acting on the other object."
    ],

    [
        "module" => "Module 6: Applications of Newton's Laws",
        "question" => "An 8 kg block sits on a frictionless 34&deg; incline. What is its acceleration down the incline? (g = 9.8 m/s&sup2;)",
        "options" => ["&asymp; 5.48 m/s&sup2;", "&asymp; 8.13 m/s&sup2;", "&asymp; 9.80 m/s&sup2;", "&asymp; 3.36 m/s&sup2;"],
        "correct" => 0,
        "explanation" => "On a frictionless incline: a = g sin&theta; = 9.8 &times; sin(34&deg;) &asymp; 9.8 &times; 0.559 &asymp; 5.48 m/s&sup2;."
    ],
    [
        "module" => "Module 6: Applications of Newton's Laws",
        "question" => "In an Atwood Machine, m1 = 10 kg and m2 = 5 kg. What is the acceleration of the system? (g = 9.8 m/s&sup2;)",
        "options" => ["&asymp; 3.27 m/s&sup2;", "&asymp; 4.90 m/s&sup2;", "&asymp; 1.63 m/s&sup2;", "&asymp; 9.80 m/s&sup2;"],
        "correct" => 0,
        "explanation" => "a = (m1-m2)g/(m1+m2) = (10-5)(9.8)/15 = 49/15 &asymp; 3.27 m/s&sup2;."
    ],
    [
        "module" => "Module 6: Applications of Newton's Laws",
        "question" => "A 1.50 kg bucket of water is whirled in a circle of radius 1.00 m. At the TOP of the loop its speed is 4.00 m/s. What is the tension in the rope at that point? (g = 9.8 m/s&sup2;)",
        "options" => ["9.3 N", "24 N", "14.7 N", "38.7 N"],
        "correct" => 0,
        "explanation" => "a_c = v&sup2;/r = 16 m/s&sup2;. Fnet = ma_c = 24 N. At the top, T + mg = Fnet, so T = 24 - (1.5)(9.8) = 24 - 14.7 = 9.3 N."
    ],

    [
        "module" => "Module 7: Work, Energy, Power",
        "question" => "A 10 N force pushes a block across a friction-free surface for a 5.0 m displacement (force and motion in the same direction). How much work is done?",
        "options" => ["50 J", "10 J", "5 J", "0 J"],
        "correct" => 0,
        "explanation" => "W = Fd cos&theta; = (10)(5)cos(0&deg;) = 50 J."
    ],
    [
        "module" => "Module 7: Work, Energy, Power",
        "question" => "How much work is done by a satellite orbiting a planet at constant speed (circular orbit)?",
        "options" => ["0 J", "A large positive value", "A large negative value", "Cannot be determined"],
        "correct" => 0,
        "explanation" => "The (centripetal) force on the satellite is always perpendicular to its velocity/displacement (cos 90&deg; = 0), so the work done is 0 J."
    ],
    [
        "module" => "Module 7: Work, Energy, Power",
        "question" => "A tired squirrel (~1 kg) does 0.50 J of work in 2 seconds. What is its power output?",
        "options" => ["0.25 W", "1.0 W", "2.0 W", "0.50 W"],
        "correct" => 0,
        "explanation" => "P = W/t = 0.50 J / 2 s = 0.25 W."
    ],

    [
        "module" => "Module 8: Impulse & Momentum",
        "question" => "What is the momentum of a 60-kg halfback moving eastward at 9 m/s?",
        "options" => ["540 kg&middot;m/s, East", "60 kg&middot;m/s, East", "9 kg&middot;m/s, East", "69 kg&middot;m/s, East"],
        "correct" => 0,
        "explanation" => "p = mv = 60 &times; 9 = 540 kg&middot;m/s, East."
    ],
    [
        "module" => "Module 8: Impulse & Momentum",
        "question" => "A car has 20,000 units of momentum. If BOTH its velocity and its mass are doubled, what is its new momentum?",
        "options" => ["80,000 units", "40,000 units", "20,000 units", "160,000 units"],
        "correct" => 0,
        "explanation" => "p = mv, so doubling both multiplies momentum by 2 &times; 2 = 4. New p = 4 &times; 20,000 = 80,000 units."
    ],
    [
        "module" => "Module 8: Impulse & Momentum",
        "question" => "Two satellites approach each other at a relative speed of 0.250 m/s to dock, but instead collide ELASTICALLY. What is their final relative velocity (separation speed)?",
        "options" => ["0.250 m/s", "0 m/s", "0.125 m/s", "0.500 m/s"],
        "correct" => 0,
        "explanation" => "In an elastic collision, the relative speed of separation equals the relative speed of approach: 0.250 m/s."
    ],

    [
        "module" => "Module 10: Equilibrium & Torque",
        "question" => "A 120 N force is applied perpendicular to a wrench, 0.2 m from the pivot bolt. What torque does this produce?",
        "options" => ["24 N&middot;m", "120 N&middot;m", "0.2 N&middot;m", "60 N&middot;m"],
        "correct" => 0,
        "explanation" => "Torque = Force &times; lever arm = (120 N)(0.2 m) = 24 N&middot;m."
    ],
    [
        "module" => "Module 10: Equilibrium & Torque",
        "question" => "If a 120 N force is applied so its line of action passes directly through the axis of rotation, what is the resulting torque?",
        "options" => ["0 N&middot;m (zero torque)", "24 N&middot;m", "120 N&middot;m", "It cannot be zero"],
        "correct" => 0,
        "explanation" => "When the force's line of action passes through the axis, the lever arm is 0, so Torque = Force &times; 0 = 0 N&middot;m."
    ],
    [
        "module" => "Module 10: Equilibrium & Torque",
        "question" => "What are the two basic conditions required for an object to be in equilibrium?",
        "options" => [
            "Net Force = 0 AND Net Torque = 0",
            "Net Force = 0 only",
            "Net Torque = 0 only",
            "Mass = 0 and Velocity = 0"
        ],
        "correct" => 0,
        "explanation" => "Equilibrium requires BOTH conditions: &Sigma;F = 0 (no net force / translational equilibrium) and &Sigma;&tau; = 0 (no net torque / rotational equilibrium)."
    ],

];
