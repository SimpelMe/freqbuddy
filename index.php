<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <?php include dirname($_SERVER['DOCUMENT_ROOT']) . "/simpel.cc/php/head.php"; ?>
    <!-- <title>FreqBuddy</title> -->
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
  </head>
  <body>
    <header>
      <?php include dirname($_SERVER['DOCUMENT_ROOT']) . "/simpel.cc/php/header.php"; ?>
      <!-- <nav>
        <a id="logo" class="cursordefault" href="/"><img src="../Simpel.png" alt="simpel icon" height="48" width="48"></a>
        <h1>FreqBuddy</h1>
        <a id="github" href="https://github.com/SimpelMe/freqbuddy" target="_blank" rel="noopener noreferrer" title="watch source code">
          <img id="github-cat" src="../github.svg" alt="github logo">
        </a>
      </nav> -->
    </header>

    <main>
      <dialog id="dialog" onclick="dialog.close()">
        <div id="dialog-wrapper">
          <p id="dialogText">Message here</p>
        </div>
      </dialog>
      <!-- TV-Kanal zu Mitten-Frequenz: Kanalnummer * 8 MHz + 306 MHz (- 4 MHz, um an den Anfang des Kanals zu gelangen)-->
      <div class="horizontal">
        <label for="channel">Freier TV-Kanal</label>
        <select name="channel" id="channel" required onchange="calculateFreqs()">
          <option value="" disabled selected hidden>auswählen …</option>
          <option value="21">21 — (470 - 478 MHz)</option>
          <option value="22">22 — (478 - 486 MHz)</option>
          <option value="23">23 — (486 - 494 MHz)</option>
          <option value="24">24 — (494 - 502 MHz)</option>
          <option value="25">25 — (502 - 510 MHz)</option>
          <option value="26">26 — (510 - 518 MHz)</option>
          <option value="27">27 — (518 - 526 MHz)</option>
          <option value="28">28 — (526 - 534 MHz)</option>
          <option value="29">29 — (534 - 542 MHz)</option>
          <option value="30">30 — (542 - 550 MHz)</option>
          <option value="31">31 — (550 - 558 MHz)</option>
          <option value="32">32 — (558 - 566 MHz)</option>
          <option value="33">33 — (566 - 574 MHz)</option>
          <option value="34">34 — (574 - 582 MHz)</option>
          <option value="35">35 — (582 - 590 MHz)</option>
          <option value="36">36 — (590 - 598 MHz)</option>
          <option value="37">37 — (598 - 606 MHz)</option>
          <option value="38" disabled>38 — Radioastronomie</option>
          <option value="39">39 — (614 - 622 MHz)</option>
          <option value="40">40 — (622 - 630 MHz)</option>
          <option value="41">41 — (630 - 638 MHz)</option>
          <option value="42">42 — (638 - 646 MHz)</option>
          <option value="43">43 — (646 - 654 MHz)</option>
          <option value="44">44 — (654 - 662 MHz)</option>
          <option value="45">45 — (662 - 670 MHz)</option>
          <option value="46">46 — (670 - 678 MHz)</option>
          <option value="47">47 — (678 - 686 MHz)</option>
          <option value="48">48 — (686 - 694 MHz)</option>
          <option value="49">49 — (694 - 698 MHz)</option>
          <option value="50" disabled>50 — 53 LTE Uplink</option>
          <option value="54">54 — (736 - 742 MHz)</option>
          <option value="55">55 — (742 - 750 MHz)</option>
          <option value="56">56 — (750 - 753 MHz)</option>
          <option value="57" disabled>57 — 64 LTE Downlink</option>
          <option value="65">65 — (823 - 832 MHz)</option>
          <option value="66" disabled>66 — 69 LTE Uplink</option>
        </select>
      </div>
      <div class="horizontal">
        <p class="label">Frequenzabstände</p>
        <form onchange="calculateFreqs()">
          <input type="radio" name="direction" id="up" value="up">
          <label for="up">an-</label>
          <input type="radio" name="direction" id="down" value="down">
          <label for="down">absteigend</label>
        </form>
      </div>
      <div class="space"></div>
      <table id="table">
        <thead>
          <tr>
            <th>#</th><th>Frequenzen <a id="copyIcon" href="#" aria-label="ganze Tabelle kopieren" title="ganze Tabelle kopieren" onclick="copyTable()">&#10697;</a></th><th></th>
          </tr>
        </thead>
        <tbody>
          <!--  inline-style="height:0em;" needed to avoid paddings top and bottom in table cells on Safari-->
          <tr id="rf1">
            <td>1</td><td id="f1"></td><td id="n1"></td>
          </tr>
          <tr id="rf2">
            <td>2</td><td id="f2"></td><td id="n2"></td>
          </tr>
          <tr id="rf3">
            <td>3</td><td id="f3"></td><td id="n3"></td>
          </tr>
          <tr id="rf4">
            <td>4</td><td id="f4"></td><td id="n4"></td>
          </tr>
          <tr id="rf5">
            <td>5</td><td id="f5"></td><td id="n5"></td>
          </tr>
          <tr id="rf6">
            <td>6</td><td id="f6"></td><td id="n6"></td>
          </tr>
          <tr id="rf7">
            <td>7</td><td id="f7"></td><td id="n7"></td>
          </tr>
          <tr id="rf8">
            <td>8</td><td id="f8"></td><td id="n8"></td>
          </tr>
        </tbody>
      </table>
      <div class="space"></div>
      <p>Belegte Fernsehkanäle lassen sich per Ortssuche bei <a href="https://fmscan.org/locsearch.php?reset=1&r=t&m=s" target="_blank" rel="noopener noreferrer">fmscan.org</a> finden.</p>
      <div class="space"></div>
      <details>
        <summary>Hilfe</summary>
        <p>Dieses Tool zeigt Dir die besten untereinander störungsfreien Funkfrequenzen innerhalb eines TV-Kanals (8-MHz-Raster).</p>
        <p>Dabei gelten folgende Regeln:
          <ul>
            <li>Dieses Tool betrachtet immer nur einen TV-Kanal.</li>
            <li>Zusätzliche Frequenzen dieses Tools aus anderen TV-Kanälen sind <b>nicht</b> auf Kompatibilität geprüft.</li>
            <ul>
              <li>Nahe liegende TV-Kanäle werden <b>nicht</b> störungsfrei funktionieren.</li>
              <li>Weit entfernte TV-Kanäle können störungsfrei funktionieren.</li>
            </ul>
            <li>Die Frequenzabstände innerhalb eines TV-Kanals sind spiegelbar. Standardmäßig wird der Abstand zu jeder höheren Frequenz größer (ansteigend). Dies kann mit der Wahl 'absteigend' umgedreht werden.</li>
            <ul>
              <li>Dies ist z.B. für ein zweites, gleichzeitig zu nutzendes Set an Frequenzen zu empfehlen. Das zweite Set sollte so weit wie möglich vom ersten entfernt sein und statt der an- die absteigenden Frequenzabstände nutzen.</li>
            </ul>
            <li>Sollen Sender und Empfänger in einer Kameratasche nebeneinander betrieben werden, muss</li>
            <ul>
              <li>der physische Abstand zwischen den Antennen des Senders und des Empfängers so groß wie möglich gewählt werden.</li>
              <li>Sender und Empfänger mindestens 8 MHz, besser 16 oder 24 MHz Abstand voneinander haben, um das Sender-Empfänger-Blocking möglichst gering zu halten.</li>
            </ul>
            <li>Es stehen höchstens 8 Frequenzen in einem TV-Kanal zur Verfügung.</li>
            <li>TV-Kanäle nahe LTE haben auf Grund der Schutzlücke weniger Frequenzen zur Verfügung.</li>
            <ul>
              <li>Mit absteigenden Frequenzabständen sinkt die Anzahl der nutzbaren Frequenzen für diese TV-Kanäle nochmals.</li>
            </ul>
            <li>Die Intermodulationsfreiheit ist berechnet mit:</li>
            <ul>
              <li>min. 400 kHz Trägerabstand</li>
              <li>min. 200 kHz Abstand 2TX-IM(3) - Intermodulation 3. Ordnung von 2 Sendern</li>
              <li>min. 100 kHz Abstand 3TX-IM(3) - Intermodulation 3. Ordnung von 3 Sendern</li>
            </ul>
            <li>Die Intermodulationsfestigkeit ist berechnet mit:</li>
            <ul>
              <li>F1: 54 %</li>
              <li>F2: 65 %</li>
              <li>F3: 49 %</li>
              <li>F4: 67 %</li>
              <li>F5: 81 %</li>
              <li>F6: 63 %</li>
              <li>F7: 82 %</li>
              <li>F8: 66 %</li>
              <li>Je höher die Prozentzahl, desto besser ist das Signal.</li>
              <li>Die Mindestanforderungen zur Intermodulationsfestigkeit sind in jedem Fall erfüllt.</li>
              <li>Diese Werte gelten für die ansteigenden Frequenzabstände. Für die absteigenden Frequenzabstände ist die Reihenfolge umzudrehen.</li>
            </ul>
            <li id="footnote1"><sup>1</sup> Handgeräte mit Frequenzen zwischen 823 - 826 MHz dürfen nur mit reduzierter Sendeleistung von maximal 82 mW betrieben werden.</li>
          </ul>
        </p>
        <p>Folgende weitere Funktionen sind im Tool enthalten:
          <ul>
            <li>Mit dem oben genannten Link zu fmscan.org kann man die bereits mit DVB-T belegten TV-Kanäle manuell ausschließen.</li>
            <li>Mit Klick auf eine einzelne Frequenz, wird diese im Vollbild angezeigt.</li>
            <li>Mit Klick auf das Kopiersymbol (&#10697;) rechts neben der Tabellenüberschrift 'Frequenzen' wird die komplette Tabelle in den Zwischenspeicher kopiert.</li>
            <li>Der zuletzt ausgewählte TV-Kanal wird für 7 Tage in einem Cookie gespeichert und beim nächsten Laden der Webseite wieder ausgewählt.</li>
            <li>Ebenso werden die an- oder absteigend ausgewählten Frequenzabstände in einem Cookie gespeichert.</li>
          </ul>
        </p>
      </details>
      <div class="space"></div>
    </main>
  </body>
  <script>
    enableCellPopup();
    calculateFreqs();
  </script>
</html>
