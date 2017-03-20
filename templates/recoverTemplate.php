<div class="container" id="connection">
  <div class="container">
    <h2>Envoyer vos identifiants par mail ?</h2>
    <p class="subtitle">Si vous n'aviez pas renseigner une adresse mail, votre compte est perdu !</p>
    <form action="index.php?action=validateRecovery" method="post">
      <div class="row">
        <span class="input input--yoko">
          <input class="input__field input__field--yoko" type="email" name="recoPsw" id="input-1" required/>
          <label class="input__label input__label--yoko" for="input-1">
            <span class="input__label-content input__label-content--yoko"><i class="fa fa-envelope"></i> Votre adresse mail</span>
          </label>
        </span>
      </div>
      <?php $this->error_handler_popup('warning','conErrorText'); ?>
      <div class="row">
        <input class="btn btn-submit" type="submit" value="Envoyer les identifiants" />
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
