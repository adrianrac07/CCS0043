<?php
/**
 * modules.php
 * ------------------------------------------------------------
 * This file just holds the REVIEWER CONTENT as a plain PHP array.
 * Each module has: an id, a title, and an "html" string with the
 * notes (already formatted with simple HTML tags).
 *
 * Keeping the content here (separate from the page that displays
 * it) makes reviewer.php much easier to read.
 * ------------------------------------------------------------
 */

$modules = [

    1 => [
        "title" => "Module 1: Introduction to Vectors",
        "html" => "
            <h3>1.1 Scalars vs. Vectors</h3>
            <ul>
                <li>A <b>scalar</b> quantity is described completely by a single number with a unit (e.g. time, temperature, mass, density).</li>
                <li>A <b>vector</b> quantity has both <b>magnitude</b> and <b>direction</b> and cannot be described by a single number alone.</li>
            </ul>

            <h3>1.2 Vectors as Arrows</h3>
            <ul>
                <li>A vector is drawn as an <b>arrow</b> with a head and a tail.</li>
                <li>The <b>magnitude</b> is shown by the length of the arrow.</li>
                <li>The arrow <b>direction</b> shows the vector's direction.</li>
            </ul>
            <table>
                <tr><th>Condition</th><th>Relationship</th></tr>
                <tr><td>Same magnitude</td><td>Equivalent</td></tr>
                <tr><td>Same direction</td><td>Parallel</td></tr>
                <tr><td>Opposite direction</td><td>Anti-parallel</td></tr>
                <tr><td>Same magnitude AND direction</td><td>Equal</td></tr>
            </table>

            <h3>1.3 Unit Vectors</h3>
            <ul>
                <li>A <b>unit vector</b> has a magnitude of exactly 1.</li>
                <li>The basic unit vectors: <b>i</b> = (1,0,0) along +x, <b>j</b> = (0,1,0) along +y, <b>k</b> = (0,0,1) along +z.</li>
                <li>2D vector: <b>A</b> = Ax i + Ay j = &lang;Ax, Ay&rang;</li>
                <li>3D vector: <b>A</b> = Ax i + Ay j + Az k = &lang;Ax, Ay, Az&rang;</li>
            </ul>

            <h3>1.4 Magnitude of a Vector</h3>
            <div class='formula'>2D: |A| = &radic;(Ax&sup2; + Ay&sup2;)</div>
            <div class='formula'>3D: |A| = &radic;(Ax&sup2; + Ay&sup2; + Az&sup2;)</div>
            <p><em>Tip: get the square root of the sum of the squares of the components.</em></p>

            <h3>1.5 Angle of Inclination (2D)</h3>
            <div class='formula'>&theta; = tan&#8315;&sup1;(Ay / Ax)</div>
            <p>This is the angle a vector makes with the <b>positive x-axis</b>. In 3D, &theta; alone is not enough to fully describe direction.</p>

            <h3>1.6 Unit Vector in the Direction of a Given Vector</h3>
            <div class='formula'>u = A / |A|</div>
            <p>Simply divide the vector by its own magnitude.</p>

            <div class='summary'><b>Quick Summary:</b> Scalars = magnitude only; vectors = magnitude + direction.
            Vectors can be written with unit vectors (i, j, k). Magnitude uses the Pythagorean-style formula;
            2D direction uses tan&#8315;&sup1;(Ay/Ax). A unit vector in the direction of A is A divided by its own magnitude.</div>
        "
    ],

    2 => [
        "title" => "Module 2: Operations on Vectors",
        "html" => "
            <h3>2.1 Addition of Vectors</h3>
            <ul>
                <li>The <b>resultant</b> is the vector sum of two or more vectors.</li>
                <li>The <b>equilibrant</b> points exactly opposite the resultant, with the <b>same magnitude</b>.</li>
                <li>Example: if the resultant is 5 m pointing North-East, the equilibrant is 5 m pointing South-West.</li>
            </ul>
            <ul>
                <li><b>1D:</b> add tail-to-head; the sum runs from the tail of the first vector to the head of the second.</li>
                <li><b>2D:</b> draw + trigonometry, or use the component method.</li>
                <li><b>3D:</b> use the component method.</li>
            </ul>

            <h3>Component Method (Steps)</h3>
            <ol>
                <li>Draw the vectors in a coordinate plane.</li>
                <li>Identify magnitudes and angles from the +x-axis.</li>
                <li>Ax = |A| cos &theta;A, Ay = |A| sin &theta;A</li>
                <li>Bx = |B| cos &theta;B, By = |B| sin &theta;B</li>
                <li>Add all x-components, then add all y-components.</li>
                <li>Write the final vector sum.</li>
            </ol>

            <h3>2.2 Dot Product (Scalar Product)</h3>
            <ul>
                <li>The result of a dot product is <b>always a scalar</b>.</li>
            </ul>
            <div class='formula'>A &middot; B = |A||B| cos &theta;<sub>AB</sub> = AxBx + AyBy + AzBz</div>
            <p>The first form is used when magnitude &amp; angle are given; the second when components are given. Both are combined to find the angle between two vectors.</p>

            <h3>2.3 Cross Product (Vector Product)</h3>
            <div class='formula'>A &times; B = |A||B| sin &theta;<sub>AB</sub></div>
            <p>The result is a <b>vector</b>; use the <b>right-hand rule</b> to get its direction. (Torque, in Module 10, is a direct application of cross product.)</p>

            <div class='summary'><b>Quick Summary:</b> Vectors add tail-to-head (1D) or via components (2D/3D).
            The dot product gives a scalar (A&middot;B = |A||B|cos&theta; = AxBx+AyBy+AzBz); the cross product gives a
            vector (|A||B|sin&theta;, direction via the right-hand rule).</div>
        "
    ],

    3 => [
        "title" => "Module 3: Motion in 1 Dimension",
        "html" => "
            <h3>3.1 Distance vs. Displacement</h3>
            <ul>
                <li><b>Distance</b> (scalar) &mdash; how much ground was covered.</li>
                <li><b>Displacement</b> (vector) &mdash; how far out of place an object is; overall change in position.</li>
            </ul>

            <h3>3.2 Speed vs. Velocity</h3>
            <ul>
                <li><b>Average speed</b> (scalar) &mdash; magnitude of how fast, over the whole journey.</li>
                <li><b>Average velocity</b> (vector) &mdash; how fast + direction, over the whole journey.</li>
                <li><b>Instantaneous speed/velocity</b> &mdash; value at one specific moment (a speedometer shows instantaneous speed).</li>
            </ul>

            <h3>3.3 Kinematics &amp; the 4 Kinematics Equations</h3>
            <p>Kinematics studies position/motion vs. time <b>without regard to the cause</b> of motion. It relates displacement (&Delta;x), velocity (v), acceleration (a), time (t).</p>
            <div class='formula'>1) vf = v0 + at</div>
            <div class='formula'>2) &Delta;x = [(vf + v0)/2] &middot; t</div>
            <div class='formula'>3) &Delta;x = v0t + &frac12;at&sup2;</div>
            <div class='formula'>4) vf&sup2; = v0&sup2; + 2a&Delta;x</div>
            <p><em>Choose the equation based on which variables are given &mdash; memorize all four!</em></p>

            <h3>3.4 Free Fall Motion</h3>
            <ul>
                <li>Motion under gravity <b>alone</b> &mdash; no air resistance, moves only along the y-axis.</li>
                <li>g = <b>&minus;9.8 m/s&sup2;</b> (always negative), same 4 kinematics equations apply.</li>
                <li><b>Dropped</b> objects: v0 = 0. <b>Tossed upward</b> objects: vf = 0 at the top (max height).</li>
                <li>All objects dropped from the same height hit the ground at the same time, regardless of mass.</li>
            </ul>

            <h3>3.5 Motion Graphs</h3>
            <ul>
                <li><b>Slope of a position vs. time graph = velocity.</b></li>
                <li>Acceleration = rate of change of velocity: a = &Delta;v/&Delta;t</li>
                <li><b>Uniform Motion (UM):</b> constant velocity &rarr; linear position graph, flat velocity graph.</li>
                <li><b>Uniformly Accelerated Motion (UAM):</b> constant acceleration &rarr; curved position graph, linear velocity graph.</li>
            </ul>

            <div class='summary'><b>Quick Summary:</b> Distance/speed are scalars; displacement/velocity are vectors.
            The 4 kinematics equations connect vf, v0, a, t, &Delta;x. Free fall reuses these equations with g = &minus;9.8 m/s&sup2;.
            On a position-time graph, slope = velocity; UM gives a straight-line position graph, UAM gives a curved one.</div>
        "
    ],

    4 => [
        "title" => "Module 4: Motion in 2 Dimensions",
        "html" => "
            <h3>4.1 Projectile Motion</h3>
            <ul>
                <li>An object thrown with initial velocity v0 that moves along a curved <b>parabolic trajectory</b> under gravity alone.</li>
                <li>Air resistance is negligible; acceleration is constant at &minus;9.8 m/s&sup2;, directed vertically downward.</li>
                <li><b>Symmetrical path:</b> launch height = landing height. <b>Non-symmetrical path:</b> they differ.</li>
            </ul>
            <div class='formula'>ax = 0 &nbsp;&nbsp; ay = &minus;9.8 m/s&sup2;</div>
            <div class='formula'>vx = v0 cos&theta; &nbsp;(constant)</div>
            <div class='formula'>vy = v0 sin&theta; &minus; gt &nbsp;(changing)</div>
            <div class='formula'>x = v0 cos(&theta;)&middot;t</div>
            <div class='formula'>y = v0 sin(&theta;)&middot;t &minus; &frac12;gt&sup2;</div>
            <p>The velocity at any point in the trajectory is the resultant of vx and vy &mdash; treat them like any 2D vector.</p>

            <h3>4.2 Uniform Circular Motion (UCM)</h3>
            <ul>
                <li>Motion in a circle <b>at constant speed</b>; direction constantly changes, so velocity is always <b>tangent</b> to the circle.</li>
                <li><b>Centripetal force</b> always points <b>toward the center</b> &mdash; &quot;centripetal&quot; describes direction, not a new type of force.</li>
            </ul>
            <table>
                <tr><th>Example</th><th>What supplies the centripetal force</th></tr>
                <tr><td>Car turning</td><td>Friction (tires on road)</td></tr>
                <tr><td>Bucket on a string</td><td>Tension</td></tr>
                <tr><td>Moon orbiting Earth</td><td>Gravity</td></tr>
            </table>

            <div class='summary'><b>Quick Summary:</b> In projectile motion, horizontal velocity is constant (ax=0) while
            vertical velocity changes due to gravity (ay=&minus;9.8 m/s&sup2;). In UCM, speed is constant but direction always changes,
            requiring a centripetal (center-pointing) force from friction, tension, gravity, etc.</div>
        "
    ],

    5 => [
        "title" => "Module 5: Newton's Laws of Motion",
        "html" => "
            <h3>5.1 What is a Force?</h3>
            <p>A force is an <b>interaction between two bodies</b>, or between a body and its environment.</p>
            <table>
                <tr><th>Force</th><th>Description</th></tr>
                <tr><td>Contact force</td><td>Direct contact between two bodies</td></tr>
                <tr><td>Normal force</td><td>Exerted by any surface in contact with an object</td></tr>
                <tr><td>Friction force</td><td>Parallel to the surface, opposes sliding</td></tr>
                <tr><td>Tension force</td><td>Pull exerted by a stretched rope/cord</td></tr>
                <tr><td>Weight</td><td>Gravitational force exerted by the Earth</td></tr>
            </table>
            <div class='formula'>F<sub>total</sub> = F1 + F2 + F3 + ... + FN (vector sum)</div>

            <h3>5.2 Law of Inertia (1st Law)</h3>
            <p><b>Inertia</b> is the tendency of a body to resist changes to its motion (a passive property).</p>
            <blockquote>&quot;A body at rest will remain at rest, and a body in motion will remain in motion, unless acted upon by an unbalanced external force.&quot;</blockquote>
            <table>
                <tr><th>Type</th><th>Definition</th><th>Example</th></tr>
                <tr><td>Inertia of Rest</td><td>Can't change state of rest by itself</td><td>Passengers jerk back when a car suddenly starts</td></tr>
                <tr><td>Inertia of Motion</td><td>Can't change state of motion by itself</td><td>Passengers lurch forward when a car suddenly stops</td></tr>
                <tr><td>Inertia of Direction</td><td>Can't change direction by itself</td><td>Passengers thrown outward on a curve</td></tr>
            </table>

            <h3>5.3 Law of Acceleration (2nd Law)</h3>
            <p>Acceleration is <b>directly proportional</b> to net force and <b>inversely proportional</b> to mass.</p>
            <div class='formula'>F = ma</div>

            <h3>5.4 Law of Interaction (3rd Law)</h3>
            <blockquote>&quot;For every action, there is an equal and opposite reaction.&quot;</blockquote>
            <p>Same size of force on both objects; opposite direction; acting on two <b>different</b> objects.</p>

            <div class='summary'><b>Quick Summary:</b> A force is an interaction (contact, normal, friction, tension, weight).
            1st Law: objects resist change in motion (inertia). 2nd Law: F = ma. 3rd Law: every action has an equal, opposite reaction on a different object.</div>
        "
    ],

    6 => [
        "title" => "Module 6: Application of Newton's Laws of Motion",
        "html" => "
            <h3>6.1 Free-Body Diagrams (FBD)</h3>
            <ul>
                <li>An FBD is an arrow-based diagram of all forces acting on a body. <b>Always the first step</b> in solving Newton's Laws problems.</li>
                <li><b>Weight:</b> Fg = mg (always downward). <b>Normal force:</b> always perpendicular to the contact surface.</li>
                <li><b>Friction</b> resists motion between two surfaces in contact.</li>
            </ul>

            <h3>6.2 The 6-Step Method</h3>
            <ol>
                <li>Draw the FBD</li>
                <li>Rotate the FBD (if needed, e.g. for inclines)</li>
                <li>Sum forces along x</li>
                <li>Sum forces along y</li>
                <li>Apply SOH-CAH-TOA</li>
                <li>Solve</li>
            </ol>
            <p><em>Always ask: is &Sigma;F = 0 (equilibrium) or &Sigma;F = ma (accelerating)?</em></p>

            <h3>6.3 Common Application Types</h3>
            <ul>
                <li>Masses on frictionless / rough inclined planes</li>
                <li>Hanging masses &amp; tension problems</li>
                <li>Accelerated elevators</li>
                <li>Pulleys (single mass + hanging mass, two inclines, the Atwood machine)</li>
                <li>Uniform Circular Motion applications (net force always points to the center, perpendicular to velocity)</li>
            </ul>

            <div class='summary'><b>Quick Summary:</b> Every application problem starts with an FBD, rotates axes if needed,
            sums forces along x and y, applies trigonometry, then solves for the unknown &mdash; checking whether the system is
            balanced (&Sigma;F=0) or accelerating (&Sigma;F=ma).</div>
        "
    ],

    7 => [
        "title" => "Module 7: Work, Energy, and Power",
        "html" => "
            <h3>7.1 Work</h3>
            <p><b>Work</b> is a scalar &mdash; energy transfer when an object is displaced by a force with a component along the displacement.</p>
            <div class='formula'>W = &Delta;E = Ef &minus; E0</div>
            <div class='formula'>W = F &middot; d = |F||d| cos &theta;</div>
            <p>1 Joule = 1 N&middot;m = 1 kg&middot;m&sup2;/s&sup2;. Negative work: force opposes motion. Zero work: force perpendicular to displacement, or no displacement at all.</p>

            <h3>7.2 Energy</h3>
            <ul>
                <li><b>Kinetic energy</b> (motion): KE = &frac12;mv&sup2;</li>
                <li><b>Potential energy</b> (position): PEgrav = mgh</li>
            </ul>

            <h3>Work-Energy Theorem</h3>
            <div class='formula'>W<sub>net</sub> = KEf &minus; KE0 = &Delta;KE</div>
            <p>Positive net work &rarr; speeding up. Negative net work &rarr; slowing down. Zero net work &rarr; constant speed.</p>

            <h3>7.3 Power</h3>
            <div class='formula'>P = W / t</div>
            <p>Power is the <b>rate</b> of doing work, measured in Watts (1 W = 1 J/s).</p>

            <div class='summary'><b>Quick Summary:</b> Work = Fd cos&theta; (a scalar); energy is kinetic (&frac12;mv&sup2;) or potential
            (mgh); the work-energy theorem ties net work directly to the change in kinetic energy; power (W/t) measures how fast work is done.</div>
        "
    ],

    8 => [
        "title" => "Module 8: Impulse and Momentum",
        "html" => "
            <h3>8.1 Momentum &amp; Impulse</h3>
            <ul>
                <li><b>Momentum (p):</b> an object's &quot;moving inertia,&quot; p = mv, unit kg&middot;m/s (vector).</li>
                <li><b>Impulse (J):</b> the effect of a net force over time, J = F&Delta;t, unit N&middot;s (vector). Also the area under a Force-vs-Time graph: J = &int;F dt.</li>
            </ul>

            <h3>8.2 Impulse-Momentum Theorem</h3>
            <div class='formula'>J = &Delta;p (Impulse = Change in Momentum)</div>
            <p>Derived directly from Newton's 2nd Law &mdash; logically equivalent to F = ma.</p>

            <h3>8.3 Conservation of Momentum</h3>
            <p>In an isolated system, total momentum before a collision = total momentum after. This follows from Newton's 3rd Law (equal, opposite forces acting for equal times).</p>

            <h3>8.4 Elastic vs. Inelastic Collisions</h3>
            <table>
                <tr><th></th><th>Elastic</th><th>Inelastic</th></tr>
                <tr><td>Momentum</td><td>Conserved</td><td>Conserved</td></tr>
                <tr><td>Kinetic Energy</td><td>Conserved</td><td><b>Not</b> conserved</td></tr>
                <tr><td>After collision</td><td>Objects separate</td><td>Extreme case: objects stick together</td></tr>
            </table>

            <div class='summary'><b>Quick Summary:</b> Momentum (p=mv) and impulse (J=F&Delta;t) are linked by J=&Delta;p.
            Momentum is always conserved in an isolated collision; kinetic energy is only conserved in elastic collisions.</div>
        "
    ],

    10 => [
        "title" => "Module 10: Equilibrium and Torque",
        "html" => "
            <h3>10.1 Conditions for Equilibrium</h3>
            <p><b>Equilibrium</b> is reached when the sum of forces along all axes is zero &mdash; no net translation or rotation.</p>
            <div class='formula'>1) Net Force = 0 &rarr; &Sigma;Fi = 0</div>
            <div class='formula'>2) Net Torque = 0 &rarr; &Sigma;&tau;i = 0</div>
            <ul>
                <li><b>Dynamic equilibrium:</b> forward reaction rate = backward reaction rate.</li>
                <li><b>Static (mechanical) equilibrium:</b> the object is completely at rest &mdash; clockwise moment = counterclockwise moment, no resultant force.</li>
            </ul>

            <h3>10.2 Torque</h3>
            <p><b>Torque</b> (moment of a force) is the tendency of a force to rotate the body it's applied to.</p>
            <div class='formula'>Torque = Force &times; Lever Arm</div>
            <div class='formula'>&tau; = r &times; F = rF sin &theta;</div>
            <p>The <b>lever arm</b> is the perpendicular distance from the axis of rotation to the line of action of the force. Torque always points along the object's angular acceleration.</p>

            <h3>Example: Torque on a 20 cm Wrench</h3>
            <table>
                <tr><th>Scenario</th><th>Torque</th></tr>
                <tr><td>120 N applied perpendicular to wrench (lever arm = 0.2 m)</td><td>24 N&middot;m</td></tr>
                <tr><td>Same 120 N, shorter/angled lever arm (0.15 m)</td><td>18 N&middot;m (less)</td></tr>
                <tr><td>120 N applied through the axis (lever arm = 0)</td><td>0 N&middot;m (none)</td></tr>
            </table>

            <div class='summary'><b>Quick Summary:</b> An object is in equilibrium when both net force and net torque are zero.
            Torque = Force &times; lever arm (&tau; = rF sin&theta;) &mdash; maximized when force is perpendicular to the lever arm, and zero when the force's line of action passes through the axis.</div>
        "
    ],

];
