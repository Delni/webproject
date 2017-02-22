<div class="container" id="inscription">
  <div class="container">
    <h2>Inscription</h2>
    <?php
    if(isset($inscErrorText))
    echo '<span class="error">' . $inscErrorText . '</span>';
    ?>
    <form  action="index.php" method="post">
      <table>
        <tr>
          <th>Login* :</th>
          <td><input type="text" name="inscLogin"/></td>
        </tr>
        <tr>
          <th>Mot de passe* :</th>
          <td><input type="password" name="inscPassword"/></td>
        </tr>
        <tr>
          <th>Mail :</th>
          <td><input type="text" name="mail"/></td>
        </tr>
        <tr>
          <th>Nom :</th>
          <td><input type="text" name="nom"/></td>
        </tr>
        <tr>
          <th>Prenom :</th>
          <td><input type="text" name="prenom"/></td>
        </tr>
        <tr>
          <th />
          <td><input type="submit" value="Creer mon compte..." /></td>
        </tr>
      </table>
    </form>
  </div>
</div>
