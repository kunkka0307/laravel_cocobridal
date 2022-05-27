<template>
  <div>
		<section class="sec_favorite_list container3">
            <h2 class="favorite_title">支払いカード情報の登録・変更</h2>
			<div class="reserve_card_box">
				<div class="input_div">
					<label class="card_label">カード番号</label>
					<input type="text" class="input input_full_width" name="password" placeholder="カード番号">
				</div>
				<div class="birthday_input input_div">
					<label>カード有効期限</label>
					<select class="input" name="birth_year">
						<option disabled selected>月</option>
					</select>/
					<select class="input" name="birth_month">
						<option disabled selected>年</option>
					</select>
				</div>
				<div class="input_div">
					<label class="card_label">セキュリティコード</label>
					<input type="text" class="input input_full_width" name="password" placeholder="">
				</div>
				<div class="input_div">
					<label class="card_label">カード名義</label>
					<input type="text" class="input input_full_width" name="password" placeholder="">
				</div>
			</div>
            <div class="submit_btn mt4">
                <button type="button" class="submit_pink_btn" @click="change">変更する</button>
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
    return { title: "支払いカード情報の登録・変更" }
  },
  created () {
	this.initialize()
  },

  data: () => ({
    form: new Form({
      comment: '',
      user_id: ''
    }),
    remember: false
  }),

  methods: {
    initialize() {
        this.form.user_id = this.user.id;
        this.form.comment = this.user.profile.comment
    },
	async change() {
        const { data } = await this.form.post(`/api/profileCommentUpdate`)
        if(data.profile.user_id) {
            this.user.profile = data.profile
            Swal.fire({
                type: 'success',
                title: "",
                text: "自己紹介変更しました。",
                reverseButtons: true,
                confirmButtonText: i18n.t('ok'),
                cancelButtonText: i18n.t('cancel')
            })
        } else {
            Swal.fire({
                type: 'error',
                title: "",
                text: "自己紹介変更失敗しました。再度登録してください。",
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
