<script lang="text/javascript">
var y = document.getElementById('dept');
for (i = 0; i < y.options.length; i++) { 
	if (y.options[i].value == '<?php echo $dept; ?>') y.selectedIndex = i;
}  
var z = document.getElementById('searchsitecode');
var Artibonite = Array();
Artibonite[0] = new Option("Claire Heureuse","54101");
Artibonite[1] = new Option("H\364pital Alma Mater de Gros Morne","52101");
Artibonite[2] = new Option("H\364pital La Providence des Gonaives","51100");
Artibonite[3] = new Option("Pierre Payen","53108");
var Centre = Array();
Centre[0] = new Option("Dispensaire March\351 Canard","62104");
var Grandeanse = Array();
Grandeanse[0] = new Option("AEADEMA de Dame-Marie","82201");
Grandeanse[1] = new Option("Centre de Sante de Pestel","83401");
Grandeanse[2] = new Option("Haitian Health Foundation","81101");
Grandeanse[3] = new Option("H\364pital Saint Antoine de Jeremie","81100");
var Nippes = Array();
Nippes[0] = new Option("H\364pital Armee du Salut Clinic B\351thel","84111");
Nippes[1] = new Option("H\364pital Sainte Th\351r\350se de Miragoane","84100");
var Nord = Array();
Nord[0] = new Option("Alliance Sant\351 de Borgne","35101");
Nord[1] = new Option("CDS La Fossette","31101");
Nord[2] = new Option("Clin. Fran\347ois DUGUE","32207");
Nord[3] = new Option("Clinique B\351thesda de Vaudreuil","32205");
Nord[4] = new Option("FOSREF, rue 16","31110");
Nord[5] = new Option("H\364pital Bienfaisance de Pignon","34401");
Nord[6] = new Option("H\364pital de La Grande Rivi\347re du Nord","33101");
Nord[7] = new Option("H\364pital Esperance de Pilate","37201");
Nord[8] = new Option("H\364pital Fort St Michel","31102");
Nord[9] = new Option("H\364pital Sacre Coeur de Milot","32301");
Nord[10] = new Option("H\364pital Saint-Jean de Limbe","36101");
Nord[11] = new Option("H\364pital Universitaire Justinien","31100");
var Nordest = Array();
Nordest[0] = new Option("Centre Medico-Social de Ouanaminthe","41201");
Nordest[1] = new Option("H\364pital de Fort Libert\351","41100");
var Nordouest = Array();
Nordouest[0] = new Option("Centre Medical Beraca","91114");
Nordouest[1] = new Option("H\364pital Evangelique de Bombardopolis","93301");
Nordouest[2] = new Option("H\364pital Immacul\351e Conception de Port de Paix","91100");
Nordouest[3] = new Option("H\364pital Notre Dame de la Paix de Jean Rabel","93401");
var Ouest = Array();
Ouest[0] = new Option("CEGYPEF","11157");
Ouest[1] = new Option("Centre de Sant\351 Bernard Mevs","11228");
Ouest[2] = new Option("Centre de Sant\351 de la Croix-des-Bouquets","13103");
Ouest[3] = new Option("Centre Eliazar Germain","11405");
Ouest[4] = new Option("Centre Hospitalier d'Arcachon 32","11316");
Ouest[5] = new Option("Centre Jeunes de Delmas","11234");
Ouest[6] = new Option("Centre Jeunes de la Plaine du cul de sac","13114");
Ouest[7] = new Option("Centre Jeunes de Lalue","11155");
Ouest[8] = new Option("Centre Lakay Centre Ville","11156");
Ouest[9] = new Option("Centre Lakay de P\351tion ville","11423");
Ouest[10] = new Option("CEPOZ Centre Espoir","11158");
Ouest[11] = new Option("CHOSCAL","11229");
Ouest[12] = new Option("CSL St Paul (montrouis)","14106");
Ouest[13] = new Option("Grace Children's Hospital","11208");
Ouest[14] = new Option("H\364pital Adventiste de Diquini","11306");
Ouest[15] = new Option("H\364pital de Carrefour","11303");
Ouest[16] = new Option("H\364pital de Fermathe (mission baptiste)","11503");
Ouest[17] = new Option("H\364pital de l'Universit\351 d'Etat d'Haiti - HUEH","11100");
Ouest[18] = new Option("H\364pital de la Communaut\351 Ha\357tienne","11404");
Ouest[19] = new Option("H\364pital Notre Dame de Petit Goave","12201");
Ouest[20] = new Option("H\364pital Saint Damien (NPFS)","11412");
Ouest[21] = new Option("H\364pital Sainte-Croix de Leogane","12108");
Ouest[22] = new Option("H\364pital St. Fran\347ois de Salle","11120");
Ouest[23] = new Option("H\364pital Universitaire de la Paix","11221");
Ouest[24] = new Option("H\364pital Wesleyen de la Gonave","15103");
Ouest[25] = new Option("Institut Fame Pereo","11127");
Ouest[26] = new Option("Maternit\351 Isaie Jeanty","11217");
Ouest[27] = new Option("SADA matheux","14103");
Ouest[28] = new Option("Sanatorium de Port-au-Prince","11123");
Ouest[29] = new Option("Sanatorium de Sigueneau","12107");
var Sud = Array();
Sud[0] = new Option("Centre de Sant\351 Lumi\350re (FINCA)","71104");
Sud[1] = new Option("Chantal","71301");
Sud[2] = new Option("Charpentier","71107");
Sud[3] = new Option("HCR d'Aquin","73101");
Sud[4] = new Option("HCR de Port Salut","72101");
Sud[5] = new Option("H\364pital Immacul\351e Conception des Cayes","71100");
Sud[6] = new Option("H\364pital Lumi\350re Bonne-Fin","73301");
Sud[7] = new Option("H\364pital Saint Boniface de Fond des Blancs","73103");
Sud[8] = new Option("H\364pital Sainte-Anne de Camp-Perrin","71401");
Sud[9] = new Option("Quatre Chemins","71106");
var Sudest = Array();
Sudest[0] = new Option("CAL de Bainet","22101");
Sudest[1] = new Option("Centre de Sant\351 de Marigot","21201");
Sudest[2] = new Option("H\364pital Saint Joseph de La Vall\351e de Jacmel","21401");
Sudest[3] = new Option("H\364pital St Michel de Jacmel","21100");
/*
function populate() {  
	alert('hello, populate');
	for (m = z.options.length - 1; m > 0; m--) z.options[m] = null; 
	var selIndex = y.selectedIndex;    
	var selArray = eval(y.options[selIndex].value)
    for (i = 0; i < selArray.length; i++) z.options[i] = new Option(selArray[i].text, selArray[i].value);
}*/
populate();
for (i = 0; i < z.options.length; i++) {
        if (z.options[i].value == '<?php echo $sitecode; ?>') z.selectedIndex = i;
}
</script>
