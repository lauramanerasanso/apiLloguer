<?php

 $rutes->definir([

     'casa/crear' => 'API/casa/insert.php',
     'casa/crear-imatges' => 'API/casa/insert_fotos.php',
     'casa/llegir' => 'API/casa/selectCasa.php',
     'casa/llegir-una' => 'API/casa/select_una_casa.php',
     'casa/editar' => 'API/casa/update_casa.php',
     'casa/editar-imatges' => 'API/casa/update_fotos.php',
     'casa/bloquejar' => 'API/casa/bloqueigCases.php',
     'usuari/check-pass' => 'API/user/checkPasswd.php',
     'usuari/change-pass' => 'API/user/changePasswd.php',
     'usuari/sessio' => 'API/user/session.php',
     'usuari/tancar-sessio' => 'API/user/tancarSessio.php',
     'data/calendari' => 'API/data/getArrayDies.php',
     'reserves' => 'API/casa/taulaReserves.php',
     'reserves/filtrar' => 'API/casa/filtrarReserves.php',
     'tarifa/crear' => 'API/casa/afegirTarifa.php',
     'tarifa/aplicar' => 'API/casa/aplicarTarifa.php',
     'casa/desbloquejar' => 'API/casa/deleteBloqueig.php',
     'tarifa/eliminar' => 'API/casa/deleteTarifa.php',
     'casa/bloqueig' => 'API/casa/selectBloqueig.php',
     'tarifa/llegir' => 'API/casa/selectTarifes.php',
     'tarifa/editar' => 'API/casa/updateAplicacioTarifa.php',
     'casa/editar-bloqueig' => 'API/casa/updateBloqueig.php',
     'reserves/grafic-pie' => 'API/casa/select_graficPie.php',
     'reserves/grafic-bar' => 'API/casa/select_graficBar.php',
     'cases' => 'API/casa/selectCasesCerca.php',
     'caracteristiques/llegir' => 'API/casa/selectCaracteristiques.php',
     'filtrarCaracteristiques' => 'API/casa/filtrarCaracteristiques.php',
     'casa/llegir-casa' => 'API/casa/select_casa.php',
     'casa/llegir-caract' => 'API/casa/selectCaract.php',


 ]);
