<script setup>
import { onMounted } from "vue"


const prop = defineProps({
    viewPort: Boolean
})

onMounted(() => {
    console.log(prop.viewPort);
})

</script>
<template>
    <p class="pr-4 text-justify break-words text-body hyphens-auto text-virtual-blue">
        Rrugëtimet Lundruese të Tiranës, është njëkohësisht një aplikacion dhe një arkiv për telefonat
        celularë dhe ueb, nismë e Tirana Art Lab - Qendra për Artin Bashkëkohor i bërë i mundur me
        mbështetjen e Bashkisë së Tiranës. Është një zgjatim i Arkivit Lundrues i Tiranës dhe është
        zhvilluar në kuadrin e projektit të bashkëpunimit Përtej Materies EU, të bashkëfinancuar nga
        Evrope Krijuese. Aplikacioni TFT përbëhet nga katër rrugëtime përmes të cilave përdoruesit mund
        të vizitojnë vendndroshje të ndryshme në qytetin e Tiranës. Rrugëtimet i drejtojnë përdoruesit në
        vende të rëndësishme historikisht dhe arkitekturore dhe ofrojnë gjithashtu mundësinë për të
        përjetuar ndërhyrje artiike në hapësira publike të së tashmes dhe së shkuarës.
    </p>
    <p class="pr-4 mt-8 text-justify break-words text-body hyphens-auto text-virtual-blue">
        Qyteti i Tiranës ka pësuar transformime madhore që nga ndryshimi i regjimeve në vitin 1991. Deri
        në mesin e viteve 2000, zhvillimi i diskursit të artit bashkëkohor në Shqipëri zhvillohej kryesisht nga
        institucionet shtetërore. Megjithatë, nga fundi i viteve 2000, nisën të shfaqen nisma të pavarura,
        duke u bërë aktorët kryesorë në zhvillimin e diskursit të artit bashkëkohor. Edicioni i parë i Bienales
        së Tiranës u zhvillua në vitin 2001 ndërsa gjatë Bienales së dytë të Tiranës në vitin 2003, artistë
        ndërkombëtarë u ftuan për të pikturuar fasadat e ndërtesave në qytet. Ky aksion u nis nga Edi
        Rama, i cili në atë kohë ishte kryebashkiaku i Tiranës.
    </p>
    <p class="pr-4 mt-8 text-justify break-words text-body hyphens-auto text-virtual-blue">
        Për shkak të mungesës së strukturave dhe hapësirave për të shfaqur artin dhe si kritikë ndaj
        ndryshimeve të shpejta dhe ndonjëherë të dhunshme në arkitekturën dhe infrastrukturën urbane të
        Tiranës, shumë artistë shqiptarë dhe të huaj nga skena e pavarur e artit kanë përdorur hapësirën
        publike si vend për të krijuar vepra arti dhe ndërhyrje artistike. Shumë nga këto ndërhyrje kanë
        qenë kritikë për zhdukje ose keqpërdorimin e hapësirës publike nga strukturat e pushtetit dhe si
        dhe një mënyrë për të ripërvetsuar sferën publike.
        Fatkeqësisht, shumë nga këto ndërhyrje, si ato zyrtare, si fasadat e prodhuara nga Bienalja e
        Tiranës, ashtu edhe ndërhyrjet e paligjshme nga skena e pavarur, kanë mbetur të
        padokumentuara, të pabotuara dhe të panjohura për publikun.
    </p>
    <p class="pr-4 mt-8 text-justify break-words text-body hyphens-auto text-virtual-blue">
        Prandaj në projektin tonë të mëparshëm, Arkivit Lundrues i Tiranës, Tirana Art Lab krijoi një
        platformë dixhitale që dokumentoi rreth 40 ndërhyrje artistike në hapësirat publike në Tiranë nga
        viti 2002 e deri më sot. Kjo platformë u zhvillua brenda një kornizë kuratoriale me një qasje
        eksperimentale për të rigjurmuar dhe rijetësuar ndërhyrjet artistike nga skena e pavarur që kishin
        cilësi artistike dhe një kontribut domethënës në debatet mbi hapësirën publike.
    </p>
    <p class="pr-4 mt-8 text-justify break-words text-body hyphens-auto text-virtual-blue">
        Rrugëtimet Lundruese të Tiranës është një aplikacion që aktivizon arkivin e krijuar në Arkivin
        Lundrues të Tiranës, duke i lejuar përdoruesit të zbulojë qytetin e Tiranës dhe trashëgiminë e tij
        historike, arkitekturore dhe artistike përmes veçorive të aplikacionit. Aplikacioni përbëhet nga rreth
        60 stacione të ndara në katër rrugëtime, duke i mundësuar përdoruesit të eksplorojë qytetin, të
        rivizitojë vendndodhjet përkatëse dhe të marrë informacion rreth vendeve, të shikojë vepra arti dhe
        të rishikojë ndërhyrjet artistike nga e kaluara, duke përjetuar gjithashtu vepra të reja virtuale.
        Me anë të një hartë, përdoruesi mund të zgjedhë rrugëtimin e tij unik përmes stacioneve të
        shpërndara nëpër qytet. Secili stacion është i pajisur me informacion të shkruar dhe zanor në
        gjuhën angleze dhe shqipe mbi vendndodhjen, informacione për artisten ose arkitekten, fotografi
        që dokumentojnë vendndodhjen/ndëhyrjen dhe materiale video nëse ka të tilla. Disa stacione
        ofrojnë gjithashtu opsionin e realitetit të shtuar (AR), duke i mundësuar përdoruesit të përjetoj
        vepra të reja arti të krijuara virtualisht vitet e fundit nga artistë të ftuar nga Tirana Art Lab.
    </p>
    <p class="pr-4 mt-8 text-justify break-words text-body hyphens-auto text-virtual-blue">
        Tirana Floating Tours is an application that activates the archive created in Tirana Floating Archive, allowing the user to discover the city of Tirana and its historical, architectural, and art heritage through the features of the app. The app consists of 60 stations divided into four tours, enabling the user to explore the city, revisit relevant locations, and obtain information about the sites, view artworks, and review art interventions from the past, while also experiencing new virtual works.
        Using a map, the user can choose their own pathway through the different stations spread around the city for each tour. Each station is equipped with text and audio information about the site in both English and Albanian language, information about the artists or architect, photographs documenting the station, and video material where applicable. Some stations also offer the option of Augmented Reality, enabling the user to experience new artworks created virtually in recent years by artists invited by Tirana Art Lab.
    </p>
    <p class="pr-4 mt-8 text-justify break-words text-body hyphens-auto text-virtual-blue">
        Koncepti i rrugëtimeve dhe arkivit &quot;lundrues&quot; rrjedh nga fakti se shumë nga ndërhyrjet artistike të paraqitura në aplikacion nuk ekzistojnë më dhe nuk kanë lënë asnjë gjurmë fizike. Megjithatë,
        kujtimet e këtyre trashëgimive kulturore jomateriale notojnë në rrëfimet private dhe kolektive të
        skenës së artit, duke luajtur një rol të rëndësishëm në formësimin e kujtesës artistike të qytetit.
    </p>
    <p class="pr-4 mt-8 text-justify break-words hyphens-auto text-body text-virtual-blue">
        Katër rrugëtimet e ofruara nga aplikacioni Rrugëtimet Lundruese të Tiranës janë: KUJTESË, që përfshin vende historike dhe arkitekturore, si dhe vepra arti apo ndërhyrje kushtuar përkujtimit dhe kundër harresës; REZISTENCË, që përfshin vende që nderojnë rezistencën, prodhojnë rezistencë dhe vepra arti që praktikojnë dhe nxisin rezistencën; NGJYRAT, që përfshin fasadat e ndërtesave të krijuara në periudhën 2002-2009 përmes "projektit të fasadave" të Bienales së Tiranës; dhe REFLEKTIME, që përfshin vendndodhje dhe vepra arti që synojnë të nxisin reflektimin mbi tema të rëndësishme që lidhen me hapësirën publike dhe artin bashkëkohor.
    </p>
    <p class="pr-4 mt-8 text-lg font-semibold text-justify text-virtual-blue">
        Rrugëtimet Lundruese të Tiranës mbështetet nga Bashkia e Tiranës.
    </p>
    <p class="pr-4 mt-8 font-medium text-justify break-words text-body hyphens-auto text-virtual-blue">
        Rrugëtimet Lundruese të Tiranës është pjesë e projektit të bashkëpunimit “Përtej Materies. Trashëgimia kulturore në prag të realitetit virtual, pjesë i të cilit është edhe Tirana Art Lab. Ky projekt afatgjatë i kushtohet qasjeve të reja digjitale të rishfaqjes, dokumentimit dhe shpërndarjes së ekspozitave, si dhe përpunimit artistik, kuratorial dhe muzeologjik të gjeneruara nga përfaqësimi virtual. Partnerët e projektit janë: ZKM | Qendra për Art dhe Media Karlsruhe, Qendra kombëtare e artit dhe kulturës Georges Pompidou, Muzeu i Ludwig – Muzeu Kortárs Művészeti, Salla e Artit në Talin, Universiteti Aalto, Tirana Art Lab - Qendra për Artin Bashkëkohor, École polytechnique fédérale de Laus.
        Përtej Materies është bashkëtfinancuar nga Programi i Evropës Krijuese të Bashkimit Evropian.
    </p>
    <br>
    <div class="grid grid-cols-2 mt-8">
        <p class="col-span-2 font-medium break-words text-body hyphens-auto text-virtual-blue">
            Menaxhere dhe kuratore e projektit
        </p>
        <p class="mt-auto font-light text-virtual-blue">Adela Demetja</p>
    </div>
    <div class="grid grid-cols-2 mt-3">
        <p class="col-span-2 font-medium break-words text-body hyphens-auto text-virtual-blue">
            Menaxher i përmbajtjes
        </p>
        <p class="col-span-2 mt-auto font-light text-virtual-blue">Redina Qose & Eni Derhemi </p>
    </div>
    <div class="grid grid-cols-2 mt-3">
        <p class="col-span-2 font-medium break-words text-body hyphens-auto text-virtual-blue">
            Kodi
        </p>
        <p class="mt-auto font-mono text-virtual-blue">Marin Nikolli  </p>
    </div>
    <div class="grid grid-cols-2 mt-3">
        <p class="col-span-2 font-medium break-words text-body hyphens-auto text-virtual-blue">
            Dizajni
        </p>
        <p class="mt-auto font-light text-virtual-blue">Studio Parallel Tirana  </p>
    </div>
    <div class="grid grid-cols-2 mt-3">
        <p class="col-span-2 font-medium break-words text-body hyphens-auto text-virtual-blue">
            Zëri
        </p>
        <p class="col-span-2 mt-auto font-light text-virtual-blue">
            Anisa Pepkolaj & Alexander Walmsley
        </p>
    </div>
    <div class="grid grid-cols-2 mt-3">
        <p class="col-span-2 font-medium break-words text-body hyphens-auto text-virtual-blue">
            Editimi audio
        </p>
        <p class="mt-auto font-light text-virtual-blue">
            Ronald Qema
        </p>
    </div>
    <div class="grid grid-cols-2 mt-3">
        <p class="col-span-2 font-medium break-words text-body hyphens-auto text-virtual-blue">
            Tekstet
        </p>
        <p class="mt-auto font-light text-virtual-blue">
            Ronald Qema
        </p>
    </div>
    <div class="grid grid-cols-2 mt-3">
        <p class="col-span-2 font-medium break-words text-body hyphens-auto text-virtual-blue">
            Imazhet
        </p>
        <p class="col-span-2 mt-auto font-light text-virtual-blue">
            Artists & Tirana Art Lab
        </p>
        <span class="mt-3 text-sm text-virtual-blue">
            Nëse dëshironi të na kontaktoni: <a href="mailto: info@tiranaartlab.org">info@tiranaartlab.org</a>
        </span>
    </div>
    <div class="w-full mt-8 mb-16" v-if="!prop.viewPort">
        <img src="/images/logosTFT.jpg" alt="supporters tft">
    </div>


</template>
