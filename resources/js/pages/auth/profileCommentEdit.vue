<template>
  <div class="sidebar_layout container2">
		<section class="sec_register sec_profile_main container3">
            <h3 class="sec_title">自己紹介</h3>
            <div class="profile_comment">
                <h4 class="profile_comment_title">休日の過ごし方やデートで行きたい場所など、<br class="sp" />自由にご記入ください。</h4>
                <textarea class="profile_comment_edit" v-model="form.comment"></textarea>
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
    return { title: "プロフィールの確認・編集" }
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
