<!-- One -->
<section id="One" class="wrapper style3">
	<div class="inner">
		<header class="align-center">
			<p>#visitbengkulu</p>
			<h2>LOGIN</h2>
		</header>
	</div>
</section>

<!-- Form -->
<section id="One" class="wrapper style3">
	<div class="inner">

		<?php echo form_open('login/getLogin','class="md-float-material" method="POST"'); ?>
			<div class="row uniform">
				<div class="6u 12u$(xsmall)">
					<input type="text" name="user" id="user" placeholder="Username" required>
				</div>
				<div class="6u$ 12u$(xsmall)">
					<input type="password" name="password" id="password" placeholder="Password" required>
				</div>

				<div class="6u$ 12u$(small)">
					<input type="checkbox" id="human" name="human" required>
					<label for="human">I am a human and not a robot</label>
				</div>
				<!-- Break -->
				<div class="12u$">
					<ul class="actions">
						<li><input type="submit" value="Login"></li>
					</ul>
				</div>
			</div>
			<?php echo form_close();; ?>

		<hr />
	</div>
</section>