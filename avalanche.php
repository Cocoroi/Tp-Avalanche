<?php

//Création du tableau
$tab_height = 50;
$tab_width = 50;
$tab = array();
for ($i = 0; $i < $tab_width; $i++) {
    array_push($tab, rand(0, ($tab_height - 1)/2));
}

$tabAffichage = [];


//Fonction de création d'un nouveau tableau pour l'affichage qui récupère les valeurs du premier.
function affichage($tabAffichage) {
    global $tab;
    $maxH = (max($tab))-1;
    $totalValues = count($tab);
    for ($i=0;$i<$totalValues;$i++) {
        for ($j=0;$j<=$maxH;$j++) {
            $tabAffichage[$j][$i]=" ";
        }
    }

    for ($i=0;$i<$totalValues;$i++) {
        for ($j=0;$j<$tab[$i];$j++) {
            if ($j<=($tab[$i])/3) {
                $tabAffichage[$maxH - $j][$i] = "\e[38;5;255m█";
            }
            elseif ($j==($tab[$i])-1) {
                $tabAffichage[$maxH - $j][$i] = "\e[38;5;255m▲";
            }
            elseif ($j==($tab[$i])-2 || $j==($tab[$i])-3 || $j==($tab[$i])-4) {
                $tabAffichage[$maxH - $j][$i] = "\e[38;5;245m█";
            }
            else {
                $tabAffichage[$maxH - $j][$i] = "\e[38;5;250m█";
            }
        }
    }

    echo "\n";
    $nb_lignes=count($tabAffichage);
    $nb_col=count($tabAffichage[0]);

    for($i=0;$i<$nb_lignes;$i++) {
        for($j=0;$j<$nb_col;$j++) {
            echo $tabAffichage[$i][$j];
        }
        echo "\n";
    }
}

//Permet de faire chuter la neige.
function tour() {
    global $tab;
    $totalValues = count($tab);
    $seuil = 1;

    for($i=0;$i<$totalValues-1;$i++) {
        $hauteur = $tab[$i] - $tab[$i+1];
        if ($hauteur > $seuil) {
            $tab[$i] = $tab[$i]-1;
            $tab[$i+1] = $tab[$i+1]+1;
        } elseif ($hauteur < (-1*$seuil)) {
            $tab[$i] = $tab[$i]+1;
            $tab[$i+1] = $tab[$i+1]-1;
        }
    }
}

affichage($tabAffichage);

//Boucle qui demande ce que l'utilisateur veut (se répète tant qu'il n'a pas fait "q").
while (1) {

    echo "\e[91m--------------------------------\n";
    echo "Commandes : \n";
    echo "-> q : quitter le programme\n";
    echo "-> v : vider la neige, tout repart a 0\n";
    echo "-> r : saisie des valeurs\n";
    echo "-> va : saisie des valeurs aléatoire\n";
    echo "-> n : chute de neige de 3 à 10m sur les sommets\n";
    echo "-> t1/t2/t3/t4 : Jeux de test\n";
    echo "--------------------------------\n";
    $command = readline("Entrer commande:");

    switch ($command) {
        case "q":
            echo "Aurevoir !\n";
            echo "\e[38;5;255m";
            exit();
            break;
        case "v":
            $tab = array();
            for ($i = 0; $i < $tab_width; $i++) {
                array_push($tab, 0);
            }
            break;
        case "va":
            $tab = array();
            for ($i = 0; $i < $tab_width; $i++) {
                array_push($tab, rand(0, $tab_height - 1));
            }
            affichage($tabAffichage);
            break;
        case "t1" :
            $tab = array();
            for ($i = 0; $i < $tab_width; $i++) {
                array_push($tab, rand(0, $tab_height - 1));
            }
            affichage($tabAffichage);
            break;
        case "t2" :
            $tab = array();
            for ($i = 0; $i < $tab_width; $i++) {
                array_push($tab, rand(0, $tab_height - 1));
            }
            affichage($tabAffichage);
            break;
        case "t3" :
            $tab = array();
            for ($i = 0; $i < $tab_width; $i++) {
                array_push($tab, rand(0, $tab_height - 1));
            }
            affichage($tabAffichage);
            break;
        case "t4" :
            $tab = array();
            for ($i = 0; $i < $tab_width; $i++) {
                array_push($tab, rand(0, $tab_height - 1));
            }
            affichage($tabAffichage);
            break;
        case "r":
            for ($i = 0; $i < $tab_height; $i++) {
                $tab[$i] = (int)readline("Entrer un chiffre (" . ($i + 1) . "/" . $tab_height . "):");
            }
            affichage($tabAffichage);
            break;
        case "n":
            $best_avalanche = (new ArrayObject($tab))->getArrayCopy();
            sort($best_avalanche, SORT_NUMERIC);
            $best_avalanche = array_reverse($best_avalanche);
            $best_avalanche = array_slice($best_avalanche, 0, 5);
            foreach ($best_avalanche as $val) {
                $key = array_search($val, $tab);
                if (isset($tab[$key - 1])) {
                    $tab[$key - 1] += rand(3, 10);
                }
                if (isset($tab[$key])) {
                    $tab[$key] += rand(3, 10);
                }
                if (isset($tab[$key + 1])) {
                    $tab[$key + 1] += rand(3, 10);
                }
            }
            affichage($tabAffichage);
            break;
        default:
            tour();
            affichage($tabAffichage);
            break;
    }
}
