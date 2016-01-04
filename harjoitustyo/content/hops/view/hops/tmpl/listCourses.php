<html>
    <head>
        <meta charset="UTF-8">
        <title>Suoritetut kurssit</title>        
    </head>

    <style>
    
    
    </style>

    <body>

        <h1>Suoritetut kurssit lukukausittain</h1>
        <br>
    
        <?php 
        
        $op_yhteensa = 0;
        $i = 1;
    
        
        while ( $i <= 3 )
        {
            if ($this->getCourseData($i) != null) {
                $nopat_syksy = 0;
                $nopat_kevat = 0;
                echo "<h2>" .$i. ". vuoden kurssit:</h2>";
                echo "<h3>Syksy:</h3>";
                foreach($this->getCourseData($i) as $kurssi) {
                    if ( $kurssi['kausi'] == 'Syksy' )
                    {
                        echo $kurssi['tunnus']. " " .$kurssi['nimi']. " " .$kurssi['op']. " op<br>";
                        $nopat_syksy = $nopat_syksy + $kurssi['op'];
                    }
                }
                echo "<h3>Opintopisteitä " .$i. ". vuoden syksynä: " .$nopat_syksy. "</h3><br>";
            
                echo "<h3>Kevät:</h3>";
                foreach($this->getCourseData($i) as $kurssi) {
                    if ( $kurssi['kausi'] == 'Kevät' )
                    {
                        echo $kurssi['tunnus']. " " .$kurssi['nimi']. " " .$kurssi['op']. " op<br>";
                        $nopat_kevat = $nopat_kevat + $kurssi['op'];
                    }
                }
                echo "<h3>Opintopisteitä " .$i. ". vuoden keväänä: " .$nopat_kevat. "</h3><br>";  
                $op_yhteensa = $op_yhteensa + $nopat_syksy + $nopat_kevat;     
            }
            
            $i++;
        
        }
        
        echo "<h3>Opintopisteitä yhteensä: " .$op_yhteensa. "</h3><br>";
                 

        ?>
        
    </body>
</html>