<?php


function countComplementaryPairs($stringData) {
    if (empty($stringData)) {
        return 0;
    }

    $pairCounts = [];

    // Iterate through the array
    foreach ($stringData as $str) {
        // Sort the characters in the string
        $sortedStr = str_split($str);
        sort($sortedStr);
        $sortedStr = implode('', $sortedStr);

        // Check if the sorted string is already in the pairCounts array
        // If it is, increment the count, otherwise, set the count to 1
        if (array_key_exists($sortedStr, $pairCounts)) {
            $pairCounts[$sortedStr]++;
        } else {
            $pairCounts[$sortedStr] = 1;
        }
    }

    $count = 0;

    // Calculate the total number of pairs
    foreach ($pairCounts as $count) {
        // For each count, calculate the number of pairs that can be formed
        // For example, if there are 3 strings with the same sorted characters,
        // you can form 3 pairs using any combination of those strings.
        $count += ($count * ($count - 1)) / 2;
    }

    return $count;
}

// Example usage:
$stringData = ["abc", "abcd", "bc", "adc"];
$result = countComplementaryPairs($stringData);
echo $result;  // Output: 3



// function shortestPalindrome(string $s): int {
//     $n = strlen($s);
//     $dp = array_fill(0, $n + 1, array_fill(0, $n + 1, 0));
//     for ($i = 0; $i <= $n; $i++) {
//       for ($j = 0; $j <= $n; $j++) {
//         if ($i == 0 || $j == 0) {
//           $dp[$i][$j] = 0;
//         } elseif ($s[$i - 1] == $s[$j - 1]) {
//           $dp[$i][$j] = $dp[$i - 1][$j - 1] + 1;
//         } else {
//           $dp[$i][$j] = max($dp[$i][$j - 1], $dp[$i - 1][$j]);
//         }
//       }
//     }
//     return $n - $dp[$n][$n];
//   }
//   $s = "abcda";
//   echo shortestPalindrome($s);

// function isPalindrome($s) {
//     return $s === strrev($s);
// }

// function shortestPalindrome($s) {
//     $insertions = 0;
//     $length = strlen($s);

//     for ($i = 0; $i < $length; $i++) {
//         if (!isPalindrome(substr($s, $i))) {
//             $insertions++;
//         } else {
//             break;
//         }
//     }

//     return $insertions;
// }

// // Example usage:
// $s = "abcda";
// $result = shortestPalindrome($s);
// echo $result; // Output: 2



?>
