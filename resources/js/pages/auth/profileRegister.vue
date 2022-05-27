<template>
  <div class="sidebar_layout container2" v-if="user">
		<section class="sec_profile">
			<div class="sec_profile_head"><img :src="user.profile.avatar_url" class="sec_profile_img"><a href="javascript:void(0);" @click="changeAvatar"><img src="/images/image_change.png" class="img_change"></a></div>
			<div class="profile_setting_list">
				<!-- プロフィール基本情報 -->
				<div class="party_subtitle"><span>プロフィール基本情報</span></div>
				<div class="profile_table">
					<div class="profile_table_row">
						<div class="profile_table_title">お名前</div>
						<div class="profile_table_text">{{user.profile.firstname}}　{{user.profile.lastname}}</div>
					</div>
					<div class="profile_table_row">
						<div class="profile_table_title">ふりがな</div>
						<div class="profile_table_text">{{user.profile.furi_firstname}}　{{user.profile.furi_lastname}}</div>
					</div>
					<div class="profile_table_row">
						<div class="profile_table_title">性別</div>
						<div class="profile_table_text">{{user.profile.gender == 'male' ? "男性" : "女性"}}</div>
					</div>
					<div class="profile_table_row">
						<div class="profile_table_title">生年月日</div>
						<div class="profile_table_text">{{user.profile.birthday | date}}</div>
					</div>
					<div class="profile_table_row">
						<div class="profile_table_title">携帯電話番</div>
						<div class="profile_table_text">{{user.profile.phone}}</div>
					</div>
				</div>
				<div class="profile_setting_btn_line">
					<button class="white_pink_btn" @click="toProfileMain">基本情報を編集する</button>
				</div>
				<!-- 自己紹介 -->
				<div class="party_subtitle"><span>自己紹介</span></div>
				<div class="party_profile_text pre-wrap" v-html="user.profile.comment"></div>
				<div class="profile_setting_btn_line">
					<button class="white_pink_btn" @click="toProfileComment">自己紹介を編集する</button>
				</div>
				<!-- プロフィール情報  -->
				<div class="party_subtitle"><span>プロフィール情報</span></div>
				<div class="profile_table">
					<div class="profile_table_row">
						<div class="profile_table_title profile_table_title_2">お住まいの<br class="sp"/>都道府県</div>
						<div class="profile_table_text">{{ user.profile.pref }}</div>
					</div>
					<div class="profile_table_row">
						<div class="profile_table_title">職業</div>
						<div class="profile_table_text">{{ user.profile.job_label }}</div>
					</div>
					<div class="profile_table_row">
						<div class="profile_table_title">身長</div>
						<div class="profile_table_text">{{ user.profile.height }}cm</div>
					</div>
					<div class="profile_table_row">
						<div class="profile_table_title">年収</div>
						<div class="profile_table_text">{{ user.profile.income_label }}</div>
					</div>
					<div class="profile_table_row">
						<div class="profile_table_title">休日</div>
						<div class="profile_table_text">{{ user.profile.holiday_label }}</div>
					</div>
					<div class="profile_table_row">
						<div class="profile_table_title">趣味</div>
						<div class="profile_table_text">{{ user.profile.hobby_label }}</div>
					</div>
					<div class="profile_table_row">
						<div class="profile_table_title">現在の住居</div>
						<div class="profile_table_text">{{ user.profile.dwelling_label }}</div>
					</div>
					<div class="profile_table_row">
						<div class="profile_table_title">お酒</div>
						<div class="profile_table_text">{{ user.profile.drink_label }}</div>
					</div>
					<div class="profile_table_row">
						<div class="profile_table_title">喫煙</div>
						<div class="profile_table_text">{{ user.profile.smoking_label }}</div>
					</div>
					<div class="profile_table_row">
						<div class="profile_table_title">料理</div>
						<div class="profile_table_text">{{ user.profile.cooking_label }}</div>
					</div>
					<div class="profile_table_row">
						<div class="profile_table_title">得意料理</div>
						<div class="profile_table_text">{{ user.profile.best_cooking ? user.profile.best_cooking : '' }}</div>
					</div>
					<div class="profile_table_row">
						<div class="profile_table_title">出身地</div>
						<div class="profile_table_text">{{ user.profile.birthplace_label }}</div>
					</div>
					<div class="profile_table_row">
						<div class="profile_table_title">血液型</div>
						<div class="profile_table_text">{{ user.profile.bloodtype_label }}</div>
					</div>
					<div class="profile_table_row">
						<div class="profile_table_title">続柄</div>
						<div class="profile_table_text">{{ user.profile.family_label }}</div>
					</div>
					<div class="profile_table_row">
						<div class="profile_table_title">婚姻歴</div>
						<div class="profile_table_text">{{ user.profile.marriage_history_label }}</div>
					</div>
				</div>
				<div class="profile_setting_btn_line">
					<button class="white_pink_btn" @click="toProfileData">プロフィール情報を編集する</button>
				</div>
			</div>
			<input type="file" ref="photoFile" class="form-control" accept="image/*" @change="changeImage" style="visibility: hidden;" />
		</section>
	</div>
</template>

<script>
import { mapGetters } from 'vuex'
import Form from 'vform'
import Cookies from 'js-cookie'
import LoginWithGithub from '~/components/LoginWithGithub'

export default {
  components: {
    LoginWithGithub
  },

  middleware: 'auth',
  layout: 'sidebar',


  metaInfo () {
    return { title: "プロフィールの確認・編集" }
  },

  data: () => ({
    form: new Form({
      avatar: undefined
    }),
    remember: false,
  }),

  methods: {
		toProfileMain() {
			this.$router.push({ name: 'profile.main' })
		},
		toProfileComment() {
			this.$router.push({ name: 'profile.comment' })
		},
		toProfileData() {
			this.$router.push({ name: 'profile.data' })
		},
		async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
		},
		changeAvatar() {
			this.$refs.photoFile.click()
		},
		changeImage(e) {
			let files = e.target.files || e.dataTransfer.files;
			if (!files.length) return;
			this.createImage(files[0]);
		},
		async createImage(file) {

			let reader = new FileReader();
			reader.onload = (e) => {
				this.user.profile.avatar_url = e.target.result;
				this.$forceUpdate();
			};
			reader.readAsDataURL(file);
			
			let formData = new FormData();
			formData.append('avatar', file);
			const { data } = await axios.post('/api/upload/avatar', formData)
			this.user.profile.avatar_url = data.url
		}
  },
	computed: {
		...mapGetters({
			user: 'auth/user',
		}),
	},
  filters: {
    date(value) {
      return moment(value).format("YYYY年　MM月　DD日");
    }
  }
}
</script>
