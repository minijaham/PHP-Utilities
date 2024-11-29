<?php

declare(strict_types=1);

final class Utils
{
    /**
     * Checks if a given class uses a specified trait.
     *
     * @param string|object $class The class name or object instance to check.
     * @param string ...$traits The fully-qualified names of the traits to check for.
     * @return bool True if the class uses any of the traits, false otherwise.
     */
    public static function uses_trait(string|object $class, string ...$traits): bool
    {
        // Initialize the class to start checking from
        $currentClass = $class;

        do {
            // Get the traits used by the current class
            $usedTraits = class_uses($currentClass);

            // Check if any of the provided traits are used by the current class
            foreach ($traits as $trait) {
                if (in_array($trait, $usedTraits)) {
                    return true;
                }
            }

            // Move to the parent class for the next iteration
            $currentClass = get_parent_class($currentClass);
        } while ($currentClass); // Continue until there are no more parent classes

        return false;
    }

    /**
     * Determine if a player wins based on a given chance.
     *
     * @param float $chance The chance of winning, from 0 (0%) to 100 (100%).
     * @return bool True if the player wins, false otherwise.
     */
    public static function chance(float $chance) : bool
    {
        // Ensure the chance is within the valid range of 0 to 100
        $chance = max(0, min($chance, 100));

        // Generate a random value between 0 and 1 using lcg_value()
        $randomValue = lcg_value();

        // Convert the given chance percentage to a float between 0 and 1
        $threshold = $chance / 100;

        // Return true if the random value is less than the threshold
        return $randomValue < $threshold;
    }

    /**
     * Determine if a player wins based on a given chance using a cryptographically secure random number generator.
     *
     * @param float $chance The chance of winning, from 0 (0%) to 100 (100%).
     * @return bool True if the player wins, false otherwise.
     */
    public static function chance_secure(float $chance) : bool
    {
        // Convert the given chance percentage to a threshold between 0 and 10000 (for precision)
        $threshold = $chance * 100;

        // Generate a cryptographically secure random integer between 0 and 10000 (inclusive)
        $randomValue = random_int(0, 10000);

        // Return true if the random value is less than the threshold
        return $randomValue < $threshold;
    }
}
