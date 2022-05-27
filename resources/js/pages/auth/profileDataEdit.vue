<template>
  <div v-if="masterData">
		<section class="sec_register sec_profile_main container2">
            <h3 class="sec_title">プロフィール変更</h3>
            <div class="register_box">
                <div class="profile_data_row">
                    <label>お住まいの都道府県</label>
                    <select class="input" v-model="form.pref">
                        <option selected disabled>お住まいの都道府県</option>
                        <option v-for="(value, index) in masterData.prefectures" :key="`prefecture_${index}`" :value="value">{{ value }}</option>
                    </select>
                </div>
                <div class="profile_data_row">
                    <label>職業</label>
                    <select class="input" v-model="form.job">
                        <option selected disabled>職業</option>
                        <option v-for="(value, index) in masterData.jobs" :key="`jobs_${index}`" :value="index">{{ value }}</option>
                    </select>
                </div>
                <div class="profile_data_row">
                    <label>身長</label>
                    <input type="text" class="input form-control" placeholder="175" v-model="form.height" />
                </div>
                <div class="profile_data_row">
                    <label>年収</label>
                    <select class="input" v-model="form.income">
                        <option selected disabled>年収</option>
                        <option v-for="(value, index) in masterData.incomes" :key="`incomes_${index}`" :value="index">{{ value }}</option>
                    </select>
                </div>
                <div class="profile_data_row">
                    <label>休日</label>
                    <select class="input" v-model="form.holiday">
                        <option selected disabled>休日</option>
                        <option v-for="(value, index) in masterData.holidays" :key="`holidays_${index}`" :value="index">{{ value }}</option>
                    </select>
                </div>
                <div class="profile_data_row hobby_row" v-if="showHobby">
                    <label>趣味</label>
                    <div class="profile_data_hobby">
                        <div class="profile_data_hobby_item" v-for="(value, index) in masterData.hobbys" :key="`hobbys_${index}`" v-bind:class="{'active': is_active_hobby(index)}" @click="toggleHobby(index)">{{ value }}</div>
                    </div>
                </div>
                <div class="profile_data_row">
                    <label>現在の住居</label>
                    <select class="input" v-model="form.dwelling">
                        <option selected disabled>現在の住居</option>
                        <option v-for="(value, index) in masterData.dwellings" :key="`dwellings_${index}`" :value="index">{{ value }}</option>
                    </select>
                </div>
                <div class="profile_data_row">
                    <label>お酒</label>
                    <select class="input" v-model="form.drink">
                        <option selected disabled>お酒</option>
                        <option v-for="(value, index) in masterData.drinks" :key="`drinks_${index}`" :value="index">{{ value }}</option>
                    </select>
                </div>
                <div class="profile_data_row">
                    <label>喫煙</label>
                    <select class="input" v-model="form.smoking">
                        <option selected disabled>喫煙</option>
                        <option v-for="(value, index) in masterData.smokings" :key="`smokings_${index}`" :value="index">{{ value }}</option>
                    </select>
                </div>
                <div class="profile_data_row">
                    <label>料理</label>
                    <select class="input" v-model="form.cooking">
                        <option selected disabled>料理</option>
                        <option v-for="(value, index) in masterData.cookings" :key="`cookings_${index}`" :value="index">{{ value }}</option>
                    </select>
                </div>
                <div class="profile_data_row">
                    <label>得意料理</label>
                    <input type="text" class="input form-control" v-model="form.best_cooking" placeholder="得意料理" />
                </div>
                <div class="profile_data_row">
                    <label>出身地</label>
                    <select class="input" v-model="form.birthplace">
                        <option selected disabled>出身地</option>
                        <option v-for="(value, index) in masterData.birthplaces" :key="`birthplaces_${index}`" :value="index">{{ value }}</option>
                    </select>
                </div>
                <div class="profile_data_row">
                    <label>血液型</label>
                    <select class="input" v-model="form.bloodtype">
                        <option selected disabled>血液型</option>
                        <option v-for="(value, index) in masterData.bloodtypes" :key="`bloodtypes_${index}`" :value="index">{{ value }}</option>
                    </select>
                </div>
                <div class="profile_data_row">
                    <label>続柄</label>
                    <select class="input" v-model="form.family">
                        <option selected disabled>続柄</option>
                        <option v-for="(value, index) in masterData.familys" :key="`familys_${index}`" :value="index">{{ value }}</option>
                    </select>
                </div>
                <div class="profile_data_row">
                    <label>婚姻歴</label>
                    <select class="input" v-model="form.marriage_history">
                        <option selected disabled>婚姻歴</option>
                        <option v-for="(value, index) in masterData.marriage_historys" :key="`marriage_historys_${index}`" :value="index">{{ value }}</option>
                    </select>
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
    return { title: "プロフィールの確認・編集" }
  },
  created () {
	this.initialize()
  },

  data: () => ({
    form: new Form({
      pref: '',
    }),
    remember: false,
    masterData: undefined,
    showHobby: true
  }),

  methods: {
    async initialize() {
        this.form.user_id = this.user.id;
        this.form.pref = this.user.profile.pref
        this.form.job = this.user.profile.job
        this.form.height = this.user.profile.height
        this.form.income = this.user.profile.income
        this.form.holiday = this.user.profile.holiday
        this.form.hobby = this.user.profile.hobby ? JSON.parse(this.user.profile.hobby) : []
        this.form.dwelling = this.user.profile.dwelling
        this.form.drink = this.user.profile.drink
        this.form.smoking = this.user.profile.smoking
        this.form.cooking = this.user.profile.cooking
        this.form.best_cooking = this.user.profile.best_cooking
        this.form.birthplace = this.user.profile.birthplace
        this.form.bloodtype = this.user.profile.bloodtype
        this.form.family = this.user.profile.family
        this.form.marriage_history = this.user.profile.marriage_history

        const { data } = await this.form.post(`/api/master/data`)
        this.masterData = data.data
    },
	async change() {
        const { data } = await this.form.post(`/api/profileDataUpdate`)
        if(data.profile.user_id) {
            this.user.profile = data.profile
            Swal.fire({
                type: 'success',
                title: "",
                text: "プロフィール変更変更しました。",
                reverseButtons: true,
                confirmButtonText: i18n.t('ok'),
                cancelButtonText: i18n.t('cancel')
            })
        } else {
            Swal.fire({
                type: 'error',
                title: "",
                text: "プロフィール変更変更失敗しました。再度登録してください。",
                reverseButtons: true,
                confirmButtonText: i18n.t('ok'),
                cancelButtonText: i18n.t('cancel')
            })
        }
    },
    toggleHobby(value) {
        this.showHobby = false
        if (this.form.hobby.includes(value)) {
            let temp = []
            for (let i = 0; i < this.form.hobby.length; i++) {
                if (this.form.hobby[i] != value) temp.push(this.form.hobby[i])
            }
            this.form.hobby = temp
        } else {
            this.form.hobby.push(value)
        }
        this.$forceUpdate()
        this.showHobby = true
    },
    is_active_hobby(value) {
        return this.form.hobby.includes(value)
    }
  },
  computed: mapGetters({
    user: 'auth/user'
  }),
}
</script>
