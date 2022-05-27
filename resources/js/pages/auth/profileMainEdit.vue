<template>
  <div class="sidebar_layout container2">
		<section class="sec_register sec_profile_main container3">
            <h3 class="sec_title">基本情報変更</h3>
            <div class="register_box">
                <div class="name_input">
                    <input class="input" type="text" v-model="form.firstname" placeholder="姓">
                    <input class="input" type="text" v-model="form.lastname" placeholder="名">
                    <input class="input" type="text" v-model="form.hira_firstname" placeholder="せい">
                    <input class="input" type="text" v-model="form.hira_lastname" placeholder="めい">
                </div>
                <div class="gender_input input_div">
                    <input type="radio" v-model="form.gender" value="male" id="gender_male"><label class="radio_label" for="gender_male">男性</label>
                    <input type="radio" v-model="form.gender" value="female" id="gender_female"><label class="radio_label" for="gender_female">女性</label>
                </div>
                <div class="birthday_input input_div">
                    <label>生年月日</label>
                    <select class="input" v-model="form.birth_year">
                        <option disabled selected>年</option>
                        <option v-for="index in 80" :key="index" :value="new Date().getFullYear() - index">{{new Date().getFullYear() - index}}年</option>
                    </select>
                    <select class="input" v-model="form.birth_month">
                        <option disabled selected>月</option>
					    <option v-for="index in 12" :key="index" :value="index">{{index}}月</option>
                    </select>
                    <select class="input" v-model="form.birth_day">
                        <option disabled selected>日</option>
					    <option v-for="index in 31" :key="index" :value="index">{{index}}日</option>
                    </select>
                </div>
                <div class="input_div">
                    <input type="text" class="input input_full_width" v-model="form.phone" placeholder="携帯番号（ハイフンなし、半角数字）">
                </div>
            </div>
            <div class="submit_btn mt4">
                <button type="submit" class="submit_pink_btn" @click="change">変更する</button>
            </div>
        </section>
	</div>
</template>

<script>
import { mapGetters } from 'vuex'
import Form from 'vform'
import Cookies from 'js-cookie'
import LoginWithGithub from '~/components/LoginWithGithub'
import Swal from 'sweetalert2'
import i18n from '~/plugins/i18n'

export default {
  components: {
    LoginWithGithub
  },

  middleware: 'auth',
  layout: 'sidebar',


  metaInfo () {
    return { title: "プロフィールの確認・編集" }
  },
  created () {
	this.initialize()
  },

  data: () => ({
    form: new Form({
      firstname: '',
      lastname: '',
      hira_firstname: '',
      hira_lastname: '',
      gender: '',
      birth_year: '',
      birth_month: '',
      birth_day: '',
      phone: '',
      user_id: ''
    }),
    remember: false
  }),

  methods: {
    initialize() {
        this.form.user_id = this.user.id;
        this.form.firstname = this.user.profile.firstname;
        this.form.lastname = this.user.profile.lastname;
        this.form.hira_firstname = this.user.profile.furi_firstname;
        this.form.hira_lastname = this.user.profile.furi_lastname;
        this.form.gender = this.user.profile.gender;
        this.form.phone = this.user.profile.phone;
        if (this.user.profile.birthday) {
            let birthday = moment(this.user.profile.birthday).format('YYYY-MM-DD')
            let temp = birthday.split("-")
            this.form.birth_year = temp[0];
            this.form.birth_month = temp[1].replace(/^0+/, '');
            this.form.birth_day = temp[2].substr(0, 2).replace(/^0+/, '');
        }
    },
	async change() {
        const { data } = await this.form.post(`/api/profileMainUpdate`)
        if(data.profile.user_id) {
            this.user.profile = data.profile
            Swal.fire({
                type: 'success',
                title: "",
                text: "基本情報変更しました。",
                reverseButtons: true,
                confirmButtonText: i18n.t('ok'),
                cancelButtonText: i18n.t('cancel')
            })
        } else {
            Swal.fire({
                type: 'error',
                title: "",
                text: "基本情報変更失敗しました。再度登録してください。",
                reverseButtons: true,
                confirmButtonText: i18n.t('ok'),
                cancelButtonText: i18n.t('cancel')
            })
        }
	}
  },
  computed: mapGetters({
    user: 'auth/user'
  }),
}
</script>
