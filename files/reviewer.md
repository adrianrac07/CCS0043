# GED0081 – College Physics 1 Reviewer
*Based strictly on: Introduction to Vectors, Operations on Vectors, Motion in 1D, Motion in 2D, Newton's Laws of Motion, Application of Newton's Laws, Work-Energy-Power, Impulse and Momentum, and Equilibrium and Torque (FEU Institute of Technology, MPS Department).*

---

## How to use this reviewer
Each module below has:
- **Key Ideas** – explained in simple, beginner-friendly language
- **Formulas** – exactly as given in your source materials
- **Worked Concepts / Examples** – the sample problems from your files (for practice — see the separate Q&A document for full solutions)
- **Module Summary** – a short recap

---

# MODULE 1: Introduction to Vectors

## 1.1 Scalars vs. Vectors
- A **scalar** quantity is described completely by a single number with a unit (e.g., time, temperature, mass, density).
- A **vector** quantity has both **magnitude** and **direction**, and cannot be described by a single number alone.

## 1.2 Vectors as Arrows
- A vector is drawn as an **arrow** with a head and a tail.
- The **magnitude** is represented by the length of the arrow.
- The **arrow direction** shows the vector's direction.

**Relationships between vectors:**
| Condition | Relationship |
|---|---|
| Same magnitude | Equivalent |
| Same direction | Parallel |
| Opposite direction | Anti-parallel |
| Same magnitude AND same direction | Equal |

## 1.3 Unit Vectors
- A **unit vector** has a magnitude of exactly 1.
- The basic (standard) unit vectors are:
  - 𝒊̂ = (1, 0, 0) → points along +x
  - 𝒋̂ = (0, 1, 0) → points along +y
  - 𝒌̂ = (0, 0, 1) → points along +z

**Vector notation:**
- A vector **A** in 2D: 𝑨 = 𝑨ₓ𝒊̂ + 𝑨ᵧ𝒋̂ = ⟨𝑨ₓ, 𝑨ᵧ⟩
- A vector **A** in 3D: 𝑨 = 𝑨ₓ𝒊̂ + 𝑨ᵧ𝒋̂ + 𝑨𝒛𝒌̂ = ⟨𝑨ₓ, 𝑨ᵧ, 𝑨𝒛⟩

Example vectors given:
- 𝑨 = 3𝒊̂ + 2𝒋̂ = ⟨3, 2⟩
- 𝑩 = 6𝒊̂ − 10𝒋̂ + 𝒌̂ = ⟨6, −10, 1⟩
- 𝑪 = 10𝒋̂ + 𝒌̂ = ⟨0, −10, 1⟩

## 1.4 Magnitude of a Vector
- 2D: **|A| = √(Aₓ² + Aᵧ²)**
- 3D: **|A| = √(Aₓ² + Aᵧ² + A𝑧²)**

> Just think of it this way: to get the magnitude of a vector, get the square root of the sum of the squares of the components.

## 1.5 Angle of Inclination
For a 2D vector: **θ = tan⁻¹(Aᵧ / Aₓ)**

> **Take note:** θ is the angle of inclination of a vector *with respect to the positive x-axis*. For a 3D vector, θ alone does not fully describe direction.

## 1.6 Finding a Unit Vector in the Direction of a Given Vector
To find the unit vector **u** in the same direction as vector **A**:

**u = A / |A|**

> Simply get the ratio of the vector itself to its magnitude.

### Module 1 Summary
Scalars = magnitude only; Vectors = magnitude + direction. Vectors can be written using unit vectors (𝒊̂, 𝒋̂, 𝒌̂). Magnitude is found using the Pythagorean-style formula, and direction (in 2D) is found using tan⁻¹(Aᵧ/Aₓ). A unit vector in the same direction as A is found by dividing A by its own magnitude.

---

# MODULE 2: Operations on Vectors

## 2.1 Addition of Vectors
- The **resultant** is the vector sum of two or more vectors — the result of adding them together.
- The **equilibrant** is a vector pointing exactly opposite to the resultant.
- Equilibrant and resultant have **equal magnitudes** but **opposite directions**.

> Example: If the resultant vector is 5 meters pointing north-east, then the equilibrant vector is 5 meters pointing south-west.

**Adding vectors depends on the number of dimensions:**
- **1D:** Add the second vector at the end (head) of the first. The vector from the tail of the first to the head of the second is the sum.
- **2D:** Draw the vectors and apply trigonometry, or use the **component method**.
- **3D:** Apply the **component method**.

### Steps to Add Arbitrary Vectors A and B (Component Method)
1. Draw the vectors in a coordinate plane.
2. Identify the magnitudes and corresponding angles with respect to the +x axis.
3. Get the x and y components of the first vector: **Aₓ = |A|cos θ_A**, **Aᵧ = |A|sin θ_A**
4. Get the x and y components of the second vector: **Bₓ = |B|cos θ_B**, **Bᵧ = |B|sin θ_B**
5. Add all the x-components together, then add all the y-components together.
6. Write your vector sum.

## 2.2 Dot Product (Scalar Product)
- One of the two types of vector multiplication (the other is cross product).
- Also called the **"scalar" product**.
- **The result of a dot product is ALWAYS a scalar quantity.**

**Two formulas:**
- When magnitude and angle between vectors are given:
  **A · B = |A||B| cos θ_AB**
- When vector components are given:
  **A · B = AₓBₓ + AᵧBᵧ + A𝑧B𝑧**

> The first formula is used when magnitudes and the angle are given. The second is used when the vectors are given in component form. Both formulas are usually used together when finding the angle between two vectors.

**Worked example from the file:**
Find A · B where A = 2î − 2ĵ − 3k̂ and B = −11î − 2ĵ + 5k̂
- A · B = (2)(−11) + (−2)(−2) + (−3)(5)
- A · B = (−22) + (4) + (−15)
- **A · B = −33**

## 2.3 Cross Product (Vector Product)
- The other type of vector multiplication.
- Also called the **"vector" product**.

**Formula when magnitude and angle are given:**
**A × B = |A||B| sin θ_AB**

- Apply the **right-hand rule** to determine the direction of the resulting vector.

### Module 2 Summary
Vectors are added differently depending on dimension (1D: tip-to-tail; 2D/3D: components). The resultant is the vector sum; the equilibrant is equal in size but opposite in direction. The dot product gives a **scalar** result (A·B = |A||B|cosθ = AₓBₓ+AᵧBᵧ+A𝑧B𝑧). The cross product gives a **vector** result (magnitude = |A||B|sinθ, direction from the right-hand rule).

---

# MODULE 3: Motion in 1 Dimension

## 3.1 Distance vs. Displacement
- **Distance** (scalar) — "how much ground an object has covered" during its motion.
- **Displacement** (vector) — "how far out of place an object is"; the object's overall change in position.

## 3.2 Average Speed vs. Average Velocity
- **Average speed** (scalar) — magnitude of how fast an object travels throughout its whole journey.
- **Average velocity** (vector) — describes how fast an object travels throughout its whole journey, including direction.

## 3.3 Instantaneous Speed vs. Instantaneous Velocity
- **Instantaneous speed** — the actual speed of an object at any specific moment.
- **Instantaneous velocity** — the actual velocity of an object at any specific moment.
> Trivia: The speedometer of a car shows **instantaneous speed**.

## 3.4 Kinematics
- **Kinematics** analyzes the positions and motions of objects as a function of time, without regard to the *causes* of motion.
- It relates the quantities: displacement (d or Δx), velocity (v), acceleration (a), and time (t).

### The 4 Kinematics Equations
| # | Equation |
|---|---|
| 1 | **v_f = v_o + at** |
| 2 | **Δx = [(v_f + v_o)/2] · t** |
| 3 | **Δx = v_o t + ½at²** |
| 4 | **v_f² = v_o² + 2aΔx** |

Where: v_f = final velocity, v_o = initial velocity, a = acceleration, t = time, Δx = displacement/position.

> Always depend on the given values when choosing which equation to use. **Memorize these for survival!**

## 3.5 Acceleration
Acceleration is defined as the rate of change of velocity of an object with respect to time:

**a = Δv/Δt = (v_f − v_o)/(t_f − t_o)**

## 3.6 Free Fall Motion
- Free fall motion is the motion of any object being acted upon **only** by the force of gravity (no air resistance / no external net force).
- An object in free fall only moves along the **y-axis**.
- All free-falling objects (on Earth) accelerate downward at **9.8 m/s²** (acceleration due to gravity).
- Free fall motion is still considered **1D kinematics**.
- **g = −9.8 m/s²** (always negative in free fall)
- All objects dropped from the same height hit the ground at the same time, regardless of mass (assuming no external force).
- Whenever a problem says an object is "in free fall," "falling," "thrown," "tossed," or similar — assume **g = −9.8 m/s²**.

**Important notes for free fall problems:**
- For a **dropped** object: initial velocity **v_o = 0**
- For a **tossed/thrown upward** object: at the **highest point**, final velocity **v_f = 0**

## 3.7 Motion Graphs
- The **position vs. time graph** shows the displacement of a moving object over a time interval. From it, you can get average speed, average velocity, and instantaneous velocity.
- The **slope of a position vs. time graph equals the velocity** of the moving object.
- **Acceleration** is the rate of change of velocity with respect to time: **a = Δv/Δt = (v_f − v_o)/(t_f − t_o)**

## 3.8 Uniform Motion (UM) vs. Uniformly Accelerated Motion (UAM)
| | Uniform Motion (UM) | Uniformly Accelerated Motion (UAM) |
|---|---|---|
| Velocity | Constant | Changing at a constant rate |
| Position vs. time graph | Perfectly linear | Curved (exponential-like) |
| Velocity vs. time graph | Constant (horizontal line) | Perfectly linear |

### Module 3 Summary
Distance/speed are scalars; displacement/velocity are vectors. There are 4 key kinematics equations relating v_f, v_o, a, t, and Δx — choose the equation based on what is given. Free fall is 1D motion under gravity alone (g = −9.8 m/s²), with v_o = 0 for drops and v_f = 0 at the peak of a toss. On a position-time graph, the slope = velocity. Uniform motion has constant velocity (linear position graph); uniformly accelerated motion has constant acceleration (linear velocity graph).

---

# MODULE 4: Motion in 2 Dimensions

## 4.1 Projectile Motion
- A form of motion where an object is thrown with an initial velocity (v₀) and moves along a **curved path** under the action of gravity alone.
- The path is called a **trajectory** and is **parabolic**.
- Air resistance is considered negligible (same assumption as free fall motion).
- The acceleration is **constant**, equal to the acceleration due to gravity, **−9.8 m/s², directed vertically downward**.

**Two Types of Trajectory Paths:**
- **Symmetrical Path** – the projectile is launched and lands at the same vertical height; the path is a symmetrical parabola.
- **Non-Symmetrical Path** – the launching height and landing height are different.

### Components of Projectile Motion
The initial velocity v₀ (a vector) has two components: **v₀ₓ** and **v₀ᵧ**
The acceleration **a** also has two components: **aₓ** and **aᵧ**

- **aₓ = 0** (acceleration in the horizontal direction is zero)
- **aᵧ = −9.8 m/s²**

**Velocity components:**
- Along the x-axis, acceleration = 0, so velocity vₓ is **constant**: **vₓ = v₀cos θ**
- Along the y-axis, acceleration = −9.8 m/s², so velocity vᵧ is **not constant**: **vᵧ = v₀sin θ − gt**

**Displacement components:**
- **x = v₀cos(θ) · t**
- **y = v₀sin(θ) · t − ½gt²**

**Velocity at any point in the trajectory:** Since you already know vₓ and vᵧ, the resultant velocity at any point can be found by treating vₓ and vᵧ like any 2D vector components (same method as getting a resultant vector, Module 1).

## 4.2 Uniform Circular Motion (UCM)
- Uniform circular motion (UCM) is the motion of an object in a circle **at a constant speed**.
- As the object moves in a circle, it is **constantly changing direction**.
- At every instant, the object moves **tangent** to the circle — so the velocity vector is always directed tangent to the circle.

### Centripetal Force
- Centripetal force always points **toward the center** of the circular path (inward).
- Any object moving in a circle experiences a centripetal force — some physical force pushes/pulls it toward the center. This is the **centripetal force requirement**. "Centripetal" simply describes the *direction* of the force, not a new kind of force.

**Real-life examples of centripetal force:**
- A car turning: **friction** on the tires provides the centripetal force.
- A bucket of water on a string, spun in a circle: **tension** provides the centripetal force.
- The Moon orbiting Earth: **gravity** provides the centripetal force.

### Module 4 Summary
Projectile motion combines constant horizontal velocity (aₓ = 0) with accelerated vertical motion (aᵧ = −9.8 m/s²); position equations are x = v₀cosθ·t and y = v₀sinθ·t − ½gt². Uniform Circular Motion keeps constant speed but constantly changing direction, requiring a centripetal (center-pointing) force supplied by whatever real force is available (friction, tension, gravity, etc.).

---

# MODULE 5: Newton's Laws of Motion

## 5.1 Forces
- A force is an **interaction between two bodies**, or between a body and its environment (not just "a push or pull," as in grade school).

**Common types of forces:**
| Force | Description |
|---|---|
| Contact force | Involves direct contact between two bodies (e.g., a push/pull with your hand) |
| Normal force | Exerted on an object by any surface it is in contact with |
| Friction force | Exerted by a surface, parallel to the surface, opposing sliding |
| Tension force | The pull exerted by a stretched rope/cord on an attached object |
| Weight (gravitational force) | The gravitational force the Earth exerts on a body |

### Net (Resultant) Force
"Any number of forces applied at a point on a body have the same effect as a single force equal to the vector sum of the forces."

**F_total = F₁ + F₂ + F₃ + ... + F_N**

Since forces are vectors, they can be broken into x- and y-components (Fₓ and Fᵧ), same as any vector (see Module 1–2).

## 5.2 Newton's Three Laws
1. **Law of Inertia** (1st Law)
2. **Law of Acceleration** (2nd Law)
3. **Law of Action and Reaction / Law of Interaction** (3rd Law)

## 5.3 Newton's First Law – Law of Inertia
- **Inertia** is the tendency of a body to resist changes to its motion — the resistance of any object to any change in its velocity.
- Inertia is a **passive property** — it does not let a body do anything except oppose active forces.

> **First Law:** "A body at rest will remain at rest, and a body in motion will remain in motion, unless it is acted upon by an unbalanced external force."

- The law has two parts: one predicting the behavior of stationary objects, and one predicting the behavior of moving objects.
- The condition described is: "...unless acted upon by an unbalanced force." As long as forces are balanced, the first law applies.

**Types of Inertia:**
| Type | Definition | Example |
|---|---|---|
| Inertia of Rest | The inability of an object to change its state of rest by itself | Passengers jerk backward when a car suddenly starts; a coin on cardboard stays when the cardboard is pulled quickly |
| Inertia of Motion | The inability of an object to change its state of motion by itself | Passengers lurch forward when a moving car suddenly stops; stirring milk; satellites orbiting a planet |
| Inertia of Direction | The inability of an object to change its direction of motion by itself | Passengers are thrown outward when a car rounds a curve |

## 5.4 Newton's Second Law – Law of Acceleration
- The **most used law** in problem solving; relates acceleration to force and mass.
- Applies to objects for which all existing forces are **not balanced**.

> "The acceleration of an object depends on two variables — the net force acting on the object, and the mass of the object."

- **Acceleration is directly proportional to the net force** acting on the object.
- **Acceleration is inversely proportional to the mass** of the object.

(This gives the well-known relationship F = ma, applied throughout the following modules.)

## 5.5 Newton's Third Law – Law of Interaction (Action-Reaction)
- Also known as the **Law of Interaction**.
> "For every action, there is an equal and opposite reaction."

- The size of the force on the first object equals the size of the force on the second object.
- The direction of the force on the first object is **opposite** to the direction of the force on the second object.

### Module 5 Summary
A force is an interaction between bodies; common types are contact, normal, friction, tension, and weight. Newton's 1st Law (inertia) says objects resist changes in motion unless acted on by an unbalanced force — with three sub-types: inertia of rest, motion, and direction. Newton's 2nd Law relates acceleration directly to net force and inversely to mass. Newton's 3rd Law says every action has an equal and opposite reaction.

---

# MODULE 6: Application of Newton's Laws of Motion

## 6.1 Free-Body Diagrams (FBD)
- A **free-body diagram** is an illustrative, arrow-based representation of the forces acting on a body (since forces are vectors).
- Rotating the system/diagram can simplify the analysis.
- **Drawing the FBD is always the first step** in solving problems related to Newton's Laws.

### Weight and Normal Force
- **Weight (Fg):** a vector quantity, also called gravitational force. Mass is in kg; weight is in N. Always points **downward** (toward Earth).
  **Fg = mg**
- **Normal Force (F_N):** always **perpendicular** to the surface the object is in contact with.

### Friction
- **Friction** is a force that resists motion when two objects are in contact.

## 6.2 General Problem-Solving Steps (Inclined Planes / Masses / Hanging Masses)
1. Draw the FBD
2. Rotate the FBD (if needed)
3. Get the summation of forces along the x-axis
4. Get the summation of forces along the y-axis
5. Apply SOH-CAH-TOA (trigonometric relationships)
6. Solve

> Key question to ask: is **ΣF = 0** (equilibrium) or **ΣF = ma** (acceleration present)?

**Types of application problems covered:**
- Masses on frictionless inclined planes
- Masses on inclined planes **with friction** (uses coefficient of kinetic friction, μₖ)
- Hanging masses / blocks suspended by ropes (tension problems)
- Accelerated elevators
- Pulleys (single mass on a table connected to a hanging mass; two masses on inclines connected via a pulley; the Atwood machine)

## 6.3 Uniform Circular Motion (UCM) Applied to Newton's Laws
- Recall: UCM is motion in a circle at constant speed, constantly changing direction.
- **Force is always perpendicular to velocity** in UCM.
- Two types of circular motion applications: **vertical circular motion** and **horizontal circular motion**.
- A common real-world example: a car turning on a level, circular road — friction between the tires and the road supplies the centripetal force.

### Module 6 Summary
Every Newton's Law application problem starts with a Free-Body Diagram. From there: rotate the FBD if needed, sum forces along x and y, apply trigonometry (SOH-CAH-TOA), then solve — checking whether the system is in equilibrium (ΣF = 0) or accelerating (ΣF = ma). This method applies to inclined planes (with or without friction), hanging masses, elevators, pulleys, and uniform circular motion problems, where the net force is always directed toward the center (perpendicular to velocity).

---

# MODULE 7: Work, Energy, and Power

## 7.1 Work
- **Work** is a **scalar** quantity.
- Work is the measure of energy transfer that occurs when an object is moved over a distance by an external force, at least part of which is applied in the direction of the displacement.

**Formulas:**
- **W = ΔE = E_f − E_o**
- **W = F · d = |F||d| cos θ**

> No work is done unless the object is displaced **and** there is a force component along the direction of motion.

**Unit of Work — the Joule (J):**
- 1 Joule = 1 Newton × 1 meter
- 1 J = 1 N·m
- 1 J = 1 (kg·m/s²) · m = 1 kg·m²/s²

### The Angle in the Work Equation
The angle θ in W = Fd cos θ is specifically the angle **between the force and the displacement vector** — this distinction matters when solving problems (e.g., a cart being pushed up an incline).

### Positive, Negative, and Zero Work
- **Negative work** happens when a force acts in the **direction opposite** to the object's motion, slowing it down (e.g., a car skidding to a stop; a baseball player sliding to a stop).
- Forces perpendicular to displacement (like gravity or the normal force on a horizontally-moving object) do **zero work**.

## 7.2 Energy
- **Energy** is a scalar quantity describing a system's ability to do work.
- All forms of energy are either **kinetic** or **potential**.
  - **Kinetic energy** — energy associated with **motion**.
  - **Potential energy** — energy associated with **position**.

### Potential Energy (PE)
- **Potential energy** is the stored energy of position possessed by an object.
- **Gravitational potential energy** — stored energy due to an object's vertical position/height.
- **Elastic potential energy** — stored energy in elastic materials due to stretching or compression.
- Gravitational PE is **directly related** to both mass and height: more massive or more elevated objects have greater gravitational PE.

**Formula: PEgrav = mgh**
where m = mass, g = gravitational acceleration, h = height.

### Kinetic Energy (KE)
- **Kinetic energy** is the energy of motion.
- Forms of KE: **vibrational**, **rotational**, and **translational** (motion from one location to another).
- Translational KE depends on **mass (m)** and **speed (v)**.

**Formula: KE = ½mv²**

### The Work-Energy Theorem
Energy transferred from one body to another equals the work done by that body. The **net work done on a system is related to its kinetic energy**.

Derivation given in the file:
- W = F·d cos θ (assuming F is parallel to d) → W = F·d
- W_net = F_net · d (Newton's 2nd Law)
- W_net = ma · d (kinematics)
- Written in terms of velocities:

**W_net = ½mv_f² − ½mv_o²**
**W_net = KE_f − KE_o**
**W_net = ΔKE**

- If W_net is **positive** → KE increases → object is **speeding up**.
- If W_net is **negative** → KE decreases → object is **slowing down**.
- If W_net = **0** → KE is maintained → object moves at **constant speed**.

## 7.3 Power
- Work has nothing to do with how much *time* the force takes to act. Work can happen quickly or slowly.
- **Power** is the quantity describing the **rate** at which work is done — the work/time ratio.

**Formula: P = W/t**

- The standard metric unit of power is the **Watt**. A unit of power = a unit of work ÷ a unit of time.

### Module 7 Summary
Work (a scalar) = force × displacement × cos θ, measured in Joules; only the force component along the displacement direction does work, and work can be positive, negative, or zero. Energy is the capacity to do work and comes in kinetic (KE = ½mv², motion) and potential (PEgrav = mgh, position) forms. The Work-Energy Theorem states the net work on a system equals its change in kinetic energy (W_net = ΔKE). Power (P = W/t) measures how fast work is done, in Watts.

---

# MODULE 8: Impulse and Momentum

## 8.1 Momentum
- **Momentum** describes an object's resistance to stopping — a kind of "moving inertia."
- Symbol: **p** (boldface); unit: **kilogram-meter per second (kg·m/s)**.
- Momentum is the product of an object's **mass and velocity**.
- Momentum is a **vector** quantity (since velocity is a vector and mass is a scalar).

**Formula: p = mv**

## 8.2 Impulse
- **Impulse** describes the effect of a net force acting on an object over time — a kind of "moving force."
- Symbol: **J** (boldface); unit: **Newton-second (N·s)**.
- Impulse is mathematically defined as the product of the average net force acting on an object and its duration.

**Formula: J = FΔt**

> In calculus, impulse can be obtained from the area under the curve of a Force vs. Time graph: **J = ∫F dt**

> A real-life example: a baseball player hitting a ball for different amounts of contact time.

## 8.3 The Impulse-Momentum Theorem
Since momentum's unit (kg·m/s) relates directly to impulse's unit (N·s), the two quantities are connected.

**Derivation (from the file):**
- Newton's 2nd Law: **F = ma**
- Combine with the definition of acceleration (a = Δv/t): **F = mΔv/t**
- Since momentum = force × time: **F·t = mΔv/t · t** → simplifies to:

**J = mΔv = Δp**   →  **Impulse = Change in Momentum**

**The Impulse-Momentum Theorem states:** the change in momentum of an object equals the impulse applied to it.
- **J = Δp**
- If mass is constant: **FΔt = mΔv**
- If mass is changing (calculus-based): **F dt = m dv + v dm**

> The impulse-momentum theorem is logically equivalent to Newton's Second Law of motion.

## 8.4 Conservation of Momentum
**Conservation of momentum** is a general law of physics stating that the total momentum of an isolated system of objects never changes — it remains constant.

> "For a collision occurring between object 1 and object 2 in an isolated system, the total momentum of the two objects before the collision equals the total momentum of the two objects after the collision. The momentum lost by object 1 equals the momentum gained by object 2."

**Why this works (from Newton's 3rd Law):**
- Forces between the two colliding objects are equal in magnitude and opposite in direction (Newton's 3rd Law).
- The time during which these forces act on both objects is the same.
- Therefore, the impulse experienced by both objects is equal (via the impulse-momentum theorem), and momentum is conserved.

> Example context given: dropping a brick onto a moving cart. The dropped brick starts with zero momentum; the loaded cart is in motion with considerable momentum.

## 8.5 Elastic vs. Inelastic Collisions
| | Elastic Collision | Inelastic Collision |
|---|---|---|
| Momentum | Conserved | Conserved |
| Kinetic Energy | Conserved | **Not** conserved |
| Objects after collision | Separate, bounce apart | The **extreme case**: objects **stick together** |
| Key idea | No dissipative force acts; all KE before the collision remains KE after | Some KE is lost (converted to heat, sound, deformation, etc.) |

### Module 8 Summary
Momentum (p = mv) is the "moving inertia" of an object; impulse (J = FΔt, or the area under a Force-vs-Time graph) is the "moving force." The Impulse-Momentum Theorem connects them: J = Δp. In any isolated system, total momentum is conserved during a collision (a direct consequence of Newton's 3rd Law). Elastic collisions conserve both momentum and kinetic energy; inelastic collisions conserve only momentum (kinetic energy is lost), with objects sticking together in the extreme case.

---

# MODULE 10: Equilibrium and Torque

## 10.1 Conditions for Equilibrium
- **Equilibrium** is attained when the summation of forces along all axes concerning an object is zero.
- An object at equilibrium has **no net influence** causing it to move, either in **translation** (linear motion) or **rotation**.
- Recall from Newton's Law applications: "**translational equilibrium**" is attained when the sums of forces along x and y are both zero.

### The Basic Conditions for Equilibrium
**1. Net Force = 0**
**ΣFᵢ = 0**
- The x- and y-components of force may be separately set to 0.
- Forces left = forces right; Forces up = forces down.

**2. Net Torque = 0**
**Στᵢ = 0**
- The axis may be chosen strategically to eliminate unknown forces.
- The sum of the clockwise torques equals the sum of the counterclockwise torques.

### Dynamic vs. Static Equilibrium
- **Dynamic equilibrium** — the steady state of a reversible reaction where the forward reaction rate equals the backward reaction rate.
- **Static equilibrium** (also called **mechanical equilibrium**) — the reaction has stopped; the system is at rest.
  > Example: a book lying still on a table — no resultant moment about a pivot (clockwise moment = counterclockwise moment), and no resultant force, so no motion.

## 10.2 Torque
- **Torque**, also called the **moment of a force**, is the tendency of a force to **rotate** the body to which it is applied.
- Torque (with respect to an axis of rotation) equals the magnitude of the force component, multiplied by the **shortest distance** between the axis and the direction of the force component.

**Formula:**
**Torque = Force applied × Lever arm**

- The **lever arm** is defined as the **perpendicular distance** from the axis of rotation to the line of action of the force.

**Full torque equation (cross product form):**

**τ = r × F = rF sin θ**

- Lever arm = r sin θ
- **Torque always points in the direction of the object's angular acceleration.**

### Example: Torque on a Wrench (from the file)
Three examples of torque exerted on a 20 cm wrench:
1. Force applied **perpendicular** to the wrench (maximum effectiveness): Torque = (120 N)(0.2 m) = **24 N·m**
2. Same force, but a **shorter, angled lever arm** (15 cm): Torque = **18 N·m** (less torque — "same force, less torque")
3. Force applied **along the direction that passes through the axis** (lever arm = 0): **Zero torque** ("same force, no torque")

> Force has maximum effectiveness in producing torque when it is exerted **perpendicular** to the wrench (or lever).

### Module 10 Summary
An object is in equilibrium when both the net force (ΣF = 0) and net torque (Στ = 0) acting on it are zero — this covers both translational and rotational equilibrium. Static equilibrium means the object is completely at rest. Torque (the "turning effect" of a force) equals Force × lever arm, or in full form, τ = rF sin θ, where the lever arm is the perpendicular distance from the axis of rotation to the line of action of the force — torque is greatest when the force is applied perpendicular to the lever arm, and zero when the force's line of action passes through the axis.

---

# Quick-Reference Formula Sheet

| Topic | Formula |
|---|---|
| Vector magnitude (2D) | \|A\| = √(Aₓ² + Aᵧ²) |
| Vector magnitude (3D) | \|A\| = √(Aₓ² + Aᵧ² + A𝑧²) |
| Angle of inclination | θ = tan⁻¹(Aᵧ/Aₓ) |
| Unit vector | u = A / \|A\| |
| Dot product | A·B = \|A\|\|B\|cosθ = AₓBₓ + AᵧBᵧ + A𝑧B𝑧 |
| Cross product (magnitude) | \|A×B\| = \|A\|\|B\|sinθ |
| Kinematics Eq. 1 | v_f = v_o + at |
| Kinematics Eq. 2 | Δx = [(v_f+v_o)/2]t |
| Kinematics Eq. 3 | Δx = v_o t + ½at² |
| Kinematics Eq. 4 | v_f² = v_o² + 2aΔx |
| Acceleration due to gravity | g = −9.8 m/s² |
| Acceleration | a = Δv/Δt |
| Projectile x-displacement | x = v₀cos(θ)t |
| Projectile y-displacement | y = v₀sin(θ)t − ½gt² |
| Newton's 2nd Law | F = ma |
| Weight | Fg = mg |
| Work | W = Fd cos θ |
| Gravitational PE | PEgrav = mgh |
| Kinetic Energy | KE = ½mv² |
| Work-Energy Theorem | W_net = ΔKE |
| Power | P = W/t |
| Momentum | p = mv |
| Impulse | J = FΔt |
| Impulse-Momentum Theorem | J = Δp |
| Torque | τ = Force × lever arm = rF sin θ |
| Equilibrium conditions | ΣF = 0 and Στ = 0 |

