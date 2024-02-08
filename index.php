<!DOCTYPE html>
<html lang="de" dir="ltr">
  <head>
    <?php include dirname($_SERVER['DOCUMENT_ROOT']) . "/simpel.cc/php/head.php"; ?>
    <!-- <meta charset="utf-8"> -->
    <!-- <title>FreqBuddy</title> -->
    <script src="script.js"></script>
    <link rel="stylesheet" href="style.css">
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
      <div>
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
        <p class="label">Abstände</p>
        <form onchange="calculateFreqs()">
          <input type="radio" name="direction" id="up" value="up">
          <label for="up" aria-label="ansteigend">↑</label>
          <input type="radio" name="direction" id="down" value="down">
          <label for="down" aria-label="absteigend">↓</label>
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
      <p>Freie TV-Kanäle mit Ortssuche finden: <a href="https://fmscan.org/locsearch.php?reset=1&r=t&m=s" target="_blank" rel="noopener noreferrer" lang="en">fmscan.org</a></p>
      <div class="space"></div>
      <h2>Hilfe</h2>
      <p>Dieses Tool berechnet die besten, untereinander störungsfreien Funkfrequenzen innerhalb eines TV-Kanals (8 MHz-Raster).</p>
      <h3>Hinweis</h3>
      <p>Es wird nur ein TV-Kanal isoliert betrachtet. Zusätzliche Frequenzen aus anderen TV-Kanälen werden <b>nicht</b> auf Kompatibilität geprüft.</p>
      <h3>Tipp</h3>
      <p>Suche als erstes mit <em lang="en">fmscan.org</em>, welche TV-Kanäle (Spalte &quot;Ch&quot;) nicht oder schwach mit DVB-T belegt sind. Komplett freie Kanäle erscheinen nicht in der Liste und sind voraussichtlich eine gute Wahl. Nutze idealer Weise keine zwei direkt benachbarten TV-Kanäle.</p>
      <h3>Weitere Funktionen</h3>
      <ul>
        <li>Klick auf eine einzelne Frequenz zeigt diese im Vollbild.</li>
        <li>Klick auf das Kopiersymbol (⧉) rechts neben der Tabellenüberschrift kopiert die komplette Tabelle in den Zwischenspeicher.</li>
        <li><em>Cookie</em>: Der zuletzt ausgewählte TV-Kanal (und die an- oder absteigend ausgewählten Frequenzabstände) werden für 7 Tage in einem Cookie gespeichert.</li>
      </ul>
      <h2>Hintergründe / Details</h2>
      <h3>Frequenzabstände</h3>
      <p>Diese sind innerhalb eines TV-Kanals spiegelbar. Standardmäßig wird der Abstand zu jeder höheren Frequenz größer (ansteigend - ↑). Dies kann umgedreht werden (absteigend - ↓). Dies ist z. B. für ein zweites, gleichzeitig zu nutzendes Set an Frequenzen zu empfehlen. Das zweite Set sollte so weit wie möglich vom ersten entfernt sein und statt der an- die absteigenden Frequenzabstände nutzen.</p>
      <h3>Antennenabstand</h3>
      <p>Sollen Sender und Empfänger dicht nebeneinander betrieben werden:</p>
      <ul>
        <li>Der physische Abstand zwischen den Antennen des Senders und Empfängers ist so groß wie möglich zu wählen.</li>
        <li>Sender und Empfänger haben mindestens 8 MHz (ein TV-Kanal) Abstand, um Sender-Empfänger-Blocking zu minimieren.</li>
      </ul>
      <h3>Hintergründe Frequenzen</h3>
      <ul>
        <li>Es stehen höchstens 8 Frequenzen in einem TV-Kanal zur Verfügung.</li>
        <li>TV-Kanäle nahe LTE haben auf Grund der Schutzlücke weniger Frequenzen zur Verfügung.</li>
        <li>Mit absteigenden Frequenzabständen (↓) sinkt die Anzahl der nutzbaren Frequenzen für diese TV-Kanäle nochmals.</li>
        <li id="footnote1"><sup>1</sup> Handgeräte im Frequenzbereich <strong>823 - 826 MHz</strong> dürfen nur mit max. 82 mW Sendeleistung betrieben werden.</li>
      </ul>
      <h3>Berechnung der Intermodulationsfreiheit</h3>
      <ul>
        <li>min. 400 kHz Trägerabstand</li>
        <li>min. 200 kHz Abstand 2TX-IM(3) - Intermodulation 3. Ordnung von 2 Sendern</li>
        <li>min. 100 kHz Abstand 3TX-IM(3) - Intermodulation 3. Ordnung von 3 Sendern</li>
        <li>Intermodulationsfestigkeit: <strong>F1</strong>: 54 %, <strong>F2</strong>: 65 %, <strong>F3</strong>: 49 %, <strong>F4</strong>: 67 %, <strong>F5</strong>: 81 %, <strong>F6</strong>: 63 %, <strong>F7</strong>: 82 %, <strong>F8</strong>: 66 % (Je höher die Prozentzahl, desto besser ist das Signal.)</li>
      </ul>
      <p>Die Mindestanforderungen zur Intermodulationsfestigkeit sind in jedem Fall erfüllt. Diese Werte gelten für die ansteigenden Frequenzabstände. Für die absteigenden Frequenzabstände ist die Reihenfolge umzudrehen.</p>
      <div class="space"></div>
    </main>
  </body>
  <script>
    enableCellPopup();
    calculateFreqs();
  </script>
</html>
