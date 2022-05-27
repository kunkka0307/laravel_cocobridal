<template>
  <section class="sec_register container3">
		<h3 class="sec_title">ログイン</h3>
		<div class="register_box">
        <div>
          <input v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }" class="input input_full_width" type="email" name="email" placeholder="メールアドレス">
          <has-error :form="form" field="email" />
        </div>
        <div class="input_div">
          <input v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }" class="input input_full_width" type="password" name="password" placeholder="パスワード">
          <has-error :form="form" field="password" /> 
        </div>
        <div class="input_div mt2 next_login_check_box">
          <input type="checkbox" id="next_login_check" v-model="remember" name="remember"><label for="next_login_check" class="next_login_check">次回から自動ログイン</label>
        </div>
        <div class="submit_btn mt4">
          <button type="submit" class="submit_pink_btn" @click="login">ログイン</button>
        </div>
        <div class="input_div">
          <p class="register_login">アカウントをお持ちでない方は<a href="/register" class="login_regiser_link">新規作成</a><br/>パスワードを忘れた方</p>
        </div>
        <div class="password_reset_border">
          <p class="password_reset_text">パスワード再設定のURLをメールにてお送りします。</p>
        </div>
        <div class="input_div">
          <input type="password" class="input input_full_width" name="password_reset_mail" placeholder="メールアドレス">
        </div>
        <div class="submit_btn password_reset_submit">
          <button class="submit_pink_btn" @click="send_reset_password">送信</button>
        </div>
		</div>
	</section>
</template>

<script>
import Form from 'vform'
import Cookies from 'js-cookie'
import LoginWithGithub from '~/components/LoginWithGithub'

export default {
  components: {
    LoginWithGithub
  },

  metaInfo () {
    return { title: this.$t('login') }
  },

  data: () => ({
    form: new Form({
      email: '',
      password: ''
    }),
    remember: false
  }),

  methods: {
    async login () {
      // Submit the form.
      const { data } = await this.form.post('/api/login')
      // Save the token.
      this.$store.dispatch('auth/saveToken', {
        token: data.token,
        remember: this.remember
      })
      // Fetch the user.
      await this.$store.dispatch('auth/fetchUser')

      // Redirect home.
      this.redirect()
    },

    redirect () {
      // const intendedUrl = Cookies.get('intended_url')

      // if (intendedUrl) {
      //   Cookies.remove('intended_url')
      //   this.$router.push({ path: intendedUrl })
      // } else {
        this.$router.push({ name: 'index' })
      // }
    },

    send_reset_password() {

    }
  }
}
</script>
