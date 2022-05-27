<template>
  <section class="sec_register container3">
		<h3 class="sec_title">新規登録</h3>
		<div class="register_box">
			<div class="name_input">
				<input class="input" type="text" name="first_name" v-model="form.fist_name" placeholder="姓" v-bind:class="{ 'is-invalid': this.errors.includes('fist_name') }">
				<input class="input" type="text" name="last_name" v-model="form.last_name" placeholder="名" v-bind:class="{ 'is-invalid': this.errors.includes('last_name') }">
				<input class="input" type="text" name="first_kana_name" v-model="form.first_kana_name" placeholder="せい" v-bind:class="{ 'is-invalid': this.errors.includes('first_kana_name') }">
				<input class="input" type="text" name="last_kana_name" v-model="form.last_kana_name" placeholder="めい" v-bind:class="{ 'is-invalid': this.errors.includes('last_kana_name') }">
			</div>
			<div class="gender_input input_div" v-bind:class="{ 'is-invalid': this.errors.includes('gender') }">
				<input type="radio" name="gender" v-model="form.gender" value="male" id="gender_male"><label class="radio_label" for="gender_male">男性</label>
				<input type="radio" name="gender" v-model="form.gender" value="female" id="gender_female"><label class="radio_label" for="gender_female">女性</label>
			</div>
			<div class="birthday_input input_div">
				<label>生年月日</label>
				<select class="input" name="birth_year" v-model="form.birth_year" v-bind:class="{ 'is-invalid': this.errors.includes('birth_year') }">
					<option disabled value="">年</option>
					<option v-for="index in 80" :key="index" :value="new Date().getFullYear() - index">{{new Date().getFullYear() - index}}年</option>
				</select>
				<select class="input" name="birth_month" v-model="form.birth_month" v-bind:class="{ 'is-invalid': this.errors.includes('birth_month') }">
					<option disabled value="">月</option>
					<option v-for="index in 12" :key="index" :value="index">{{index}}月</option>

				</select>
				<select class="input" name="birth_day" v-model="form.birth_day" v-bind:class="{ 'is-invalid': this.errors.includes('birth_day') }">
					<option disabled value="">日</option>
					<option v-for="index in 31" :key="index" :value="index">{{index}}日</option>
				</select>
			</div>
			<div class="input_div">
				<input type="number" class="input input_full_width" name="phone" v-model="form.phone" placeholder="携帯番号（ハイフンなし、半角数字）" v-bind:class="{ 'is-invalid': this.errors.includes('phone') }">
			</div>
			<div class="input_div">
				<select class="input input_full_width" name="pref" v-model="form.pref" v-bind:class="{ 'is-invalid': this.errors.includes('pref') }">
					<option disabled value="">お住まいの都道府県</option>
					<option v-for="(pref, index) in area" :key="index" :value="pref">{{pref}}</option>
				</select>
			</div>
			<h4 class="register_login_info">ログイン情報</h4>
			<div class="input_div">
				<input type="text" class="input input_full_width" v-model="form.email" name="email" placeholder="メールアドレス" v-bind:class="{ 'is-invalid': this.errors.includes('email') }">
			</div>
			<div class="input_div">
				<input type="password" class="input input_full_width" v-model="form.password" name="password" placeholder="パスワード" v-bind:class="{ 'is-invalid': this.errors.includes('password') }">
			</div>
			<div class="submit_btn">
				<button type="submit" class="submit_pink_btn" @click="register">登録</button>
			</div>
			<div class="input_div">
				<p class="register_login">登録済みの方はこちら <a href="login" class="regiser_login_link">ログイン</a></p>
			</div>
		</div>
	</section>
</template>

<script>
import Form from 'vform'
import LoginWithGithub from '~/components/LoginWithGithub'
import {AREA} from '~/plugins/constants'
import helper from '~/plugins/helper'
import Swal from 'sweetalert2'
import i18n from '~/plugins/i18n'

export default {
  components: {
    LoginWithGithub
  },


  metaInfo () {
    return { title: this.$t('register') }
  },

  data: () => ({
	area: AREA,
    form: new Form({
      fist_name: '',
	  last_name: '',
	  name: '',
      first_kana_name: '',
	  last_kana_name: '',
	  gender: '',
	  birth_year: '',
	  birth_month: '',
	  birth_day: '',
	  phone: '',
	  pref: '',
      email: '',
	  password: '',
	  role_id: 2
    }),
    mustVerifyEmail: false,
	errors: []
  }),

  methods: {
	  
	validate() {
		this.errors = helper.validChecks(this.form, ['busy',  'successful', 'name']);
		console.log(this.errors);

		if (this.errors.length > 0) {
			return false;
		}
		return true;
	},
    async register () {
		if (this.validate()) {
			// Register the user.
			const { data } = await this.form.post('/api/register')
			console.log(data);
			// Must verify email fist.
			if (data.status == 0) {
				Swal.fire({
					type: 'error',
					title: "",
					text: "新規登録失敗しました。再度登録してください。",
					reverseButtons: true,
					confirmButtonText: i18n.t('ok'),
					cancelButtonText: i18n.t('cancel')
				})
			} else {
				
				if (data.status == 3) {
					Swal.fire({
						type: 'error',
						title: "",
						text: "既に登録済みのメールアドレスです。",
						reverseButtons: true,
						confirmButtonText: i18n.t('ok'),
						cancelButtonText: i18n.t('cancel')
					})
				} else {
					this.$router.push({ name: 'verifysended' })
				}
			}
		} else {
			Swal.fire({
				type: 'error',
				title: "",
				text: "必須項目を入力してください。",
				reverseButtons: true,
				confirmButtonText: i18n.t('確認'),
				cancelButtonText: i18n.t('cancel')
			})
		}
    }
  }
}
</script>
