<div class="input-form">
    <h2>Sicurezza</h2>
        <form id="form" method="post" action="index.php?page=istruttore&subpage=home<?= $vd->scriviToken('&')?>">
           <input type="hidden" name="cmd" value="cambia_sicurezza"/>
           <div id="info">
                 
            </div>
            <h3>Password</h3>
            <label for="pw"><strong>Nuova Password:</strong></label>
            <input type="password" class="check" name="password" id="pw"/>
            <span id="password"></span>
            <br/>
            <h3>Username</h3>
            <label for="usr"><strong>Nuovo Username:</strong></label>
            <input type="text" class="check" name="username" id="usr"/>
            <span id="username"></span>
            <br/>

            <input type="submit" id="submit" name="salva" value="Salva"/>
        </form>
</div>

