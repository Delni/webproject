<div class="container" id="connection">
  <div class="container">
    <h2>Connexion</h2>
    <form action="index.php" method="post">
      <div class="row">
        <span class="input input--yoko">
          <input class="input__field input__field--yoko" type="text" name="conLogin" id="input-1" />
          <label class="input__label input__label--yoko" for="input-1">
            <span class="input__label-content input__label-content--yoko"><i class="fa fa-user-circle"></i> Login</span>
          </label>
        </span>
        <span class="input input--yoko">
          <input class="input__field input__field--yoko" type="password" name="conPassword" id="input-2" />
          <label class="input__label input__label--yoko" for="input-2">
            <span class="input__label-content input__label-content--yoko"><i class="fa fa-unlock-alt"></i> Mot de passe</span>
          </label>
        </span>
      </div>
      <?php $this->error_handler_popup('warning','conErrorText'); ?>
      <div class="row">
        <input class="btn btn-submit" type="submit" value="Se connecter" />
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
