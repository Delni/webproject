<div class="container" id="inscription">
  <div style="margin-top: 2.5%">
    <h2>Inscription</h2>
    <p class="subtitle">Les champs suivis de <span class="obligatoire">*</span> sont obligatoires</p>
    <?php $this->error_handler_popup('warning','inscErrorText'); ?>
    <form class="row" action="index.php" method="post">
      <div>
        <span class="input input--yoko">
          <input class="input__field input__field--yoko" type="text" name="inscLogin" id="input-1" required/>
          <label class="input__label input__label--yoko" for="input-1">
            <span class="input__label-content input__label-content--yoko"><i class="fa fa-user-circle"></i> Login <span class="obligatoire">*</span> (Caractères interdits : " \ `)</span>
          </label>
        </span>
      </div>
      <div>
        <span class="input input--yoko">
          <input class="input__field input__field--yoko" type="password" name="inscPassword" id="input-2" required/>
          <label class="input__label input__label--yoko" for="input-2">
            <span class="input__label-content input__label-content--yoko"><i class="fa fa-unlock-alt"></i> Mot de passe <span class="obligatoire">*</span><a target="_blank" href="http://www.trypap.com/" class="pull-right"><i class="easter-egg fa fa-circle-o"></i></a></span>
          </label>
        </span>
        <span class="input input--yoko">
          <input class="input__field input__field--yoko" type="password" name="inscPasswordConfirm" id="input-3" />
          <label class="input__label input__label--yoko" for="input-2">
            <span class="input__label-content input__label-content--yoko"><i class="fa fa-unlock-alt"></i> Confirmez le mot de passe</span>
          </label>
        </span>
      </div>
      <div >
        <span class="input input--yoko">
          <input class="input__field input__field--yoko" type="text" name="inscFirstName" id="input-4" />
          <label class="input__label input__label--yoko" for="input-1">
            <span class="input__label-content input__label-content--yoko"><i class="fa fa-vcard-o"></i> Prénom</span>
          </label>
        </span>
        <span class="input input--yoko">
          <input class="input__field input__field--yoko" type="text" name="inscName" id="input-5" />
          <label class="input__label input__label--yoko" for="input-2">
            <span class="input__label-content input__label-content--yoko"><i class="fa fa-vcard"></i> Nom</span>
          </label>
        </span>
      </div>
      <div>
        <span class="input input--yoko">
          <input class="input__field input__field--yoko" type="email" name="inscMail" id="input-6" required/>
          <label class="input__label input__label--yoko" for="input-2">
            <span class="hasinfo input__label-content input__label-content--yoko"><i class="fa fa-envelope"></i> E-mail <span class="obligatoire">*</span><span class="infobulle">Nous n'utiliserons votre email qu'uniquement <br>pour vous aider à récuperer votre compte si vous oubliez vos identifiants <br>et confirmer votre inscription!</span></span>
          </label>
        </span>
      </div>
      <div>
        <input class="btn btn-submit" type="submit" value="Créer mon compte..." />
        <a href="index.php" class="btn btn-warning">Retour</a>
      </div>
  </form>


  </div>
</div>
<script src="js/classie.js"></script>
<script>
  (function() {
    // trim polyfill : https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/Trim
    if (!String.prototype.trim) {
      (function() {
        // Make sure we trim BOM and NBSP
        var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
        String.prototype.trim = function() {
          return this.replace(rtrim, '');
        };
      })();
    }

    [].slice.call( document.querySelectorAll( 'input.input__field' ) ).forEach( function( inputEl ) {
      // in case the input is already filled..
      if( inputEl.value.trim() !== '' ) {
        classie.add( inputEl.parentNode, 'input--filled' );
      }

      // events:
      inputEl.addEventListener( 'focus', onInputFocus );
      inputEl.addEventListener( 'blur', onInputBlur );
    } );

    function onInputFocus( ev ) {
      classie.add( ev.target.parentNode, 'input--filled' );
    }

    function onInputBlur( ev ) {
      if( ev.target.value.trim() === '' ) {
        classie.remove( ev.target.parentNode, 'input--filled' );
      }
    }
  })();
</script>
