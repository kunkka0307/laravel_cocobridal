<template>
  <section class="sec_register container2">
		<h3 class="sec_title">パーティー検索</h3>
		<div class="register_box">
			<div class="input_div search_item search_item_sp" v-if="!user">
				<label class="keyword_input_label">あなたの性別</label>
				<div class="serach_item_main search_checks">
					<input type="radio" name="gender" id="male" value="male" v-model="form.gender"><label class="radio_label" for="male">男性</label>
					<input type="radio" name="gender" id="female" value="female" v-model="form.gender"><label class="radio_label" for="female">女性</label>
				</div>
			</div>
			<div class="birthday_input input_div search_item" v-if="!user">
				<label>あなたの年齢</label>
				<div>
					<select class="input" v-model="form.your_age">
						<option value="">年齢</option>
						<option v-for="index in 41" :key="index" :value="index + 17">{{index + 17}}歳</option>
					</select>
				</div>
			</div>
			<div class="birthday_input input_div search_item">
				<label>お相手の年齢</label>
				<div class="age_search">
					<select class="input" v-model="form.age_from">
						<option value="">年齢</option>
						<option v-for="index in 41" :key="index" :value="index + 17">{{index + 17}}歳</option>
					</select>～
					<select class="input" v-model="form.age_to">
						<option value="">年齢</option>
						<option v-for="index in 41" :key="index" :value="index + 17">{{index + 17}}歳</option>
					</select>
				</div>
			</div>
			<div class="input_div search_item">
				<label style="word-break: keep-all; margin-right: 4rem;">エリア</label>
				<div class="serach_item_main area_select" @click="openAreaSelectModal">{{areaTexts}}<img src="/images/chevron-right.png"></div>
			</div>
			 <modal 
				name="area-select-modal"
				:resizable = true
				width = "750"
				height = "auto">
					<div class="area_select_modal">
						<p class="result_text">{{areaTexts}}</p>
						<div class="profile_data_hobby">
							<div class="profile_data_hobby_item" v-for="(pref, index) in area" :key="index" v-bind:class="{'active': is_active_prepf(pref)}" @click="togglePref(pref)">{{ pref }}</div>
						</div>
						<div class="center" style="margin-bottom: 3rem">
							<button type="button" class="submit_pink_btn" @click="closeAreaSelectModal">確認</button>
						</div>
					</div>
			</modal>
			
			
			<div class="input_div search_item">
				<label>日付</label>
				<div class="serach_item_main"><date-picker v-model="form.open_at" valueType="format"></date-picker></div>
			</div>
			<div class="input_div search_item">
				<label>開始時間<br class="sp"/><span>※開催時間は<br class="sp"/>1時間30分程度です</span></label>
				<div class="serach_item_main birthday_input">
					<select class="input" v-model="form.open_time">
						<option value='0'>指定なし</option>
						<option v-for="index in 16" :key="index" :value="time_value(index + 7)">{{index + 7}}:00〜</option>
					</select>
				</div>
			</div>
			<div class="input_div search_item search_item_sp">
				<label class="keyword_input_label">フリーワード</label>
				<div class="serach_item_main"><input class="input keyword_input" type="text" name="keyword" placeholder="年収600万、個室、新宿…" v-model="form.keyword"></div>
			</div>
			<div class="input_div search_item search_item_sp">
				<label class="keyword_input_label">年齢重視で選ぶ</label>
				<div class="serach_item_main search_checks">
					<input type="radio" name="age_range" id="age20" value="20" v-model="form.age_range"><label class="radio_label" for="age20">20代</label>
					<input type="radio" name="age_range" id="age30" value="30" v-model="form.age_range"><label class="radio_label" for="age30">30代</label>
					<input type="radio" name="age_range" id="age40" value="40" v-model="form.age_range"><label class="radio_label" for="age40">40代</label>
				</div>
			</div>
			<div class="input_div search_item search_item_sp">
				<label class="keyword_input_label">価値観重視で選ぶ</label>
				<div class="serach_item_main search_checks">
					<input type="radio" name="sense" id="sense1" value="1" v-model="form.value_sense"><label class="radio_label" for="sense1">価値観１</label>
					<input type="radio" name="sense" id="sense2" value="2" v-model="form.value_sense"><label class="radio_label" for="sense2">価値観2</label>
					<input type="radio" name="sense" id="sense3" value="3" v-model="form.value_sense"><label class="radio_label" for="sense3">価値観３</label>
				</div>
			</div>
			<div class="input_div search_image_checks">
				<label class="keyword_input_label">会場で選ぶ</label>
				<div class="search_image_check_list">
					<ul>
						<li v-for="(room, index) in rooms" :key="`room_${index}`">
							<input type="checkbox" :id="`room_type${index}`" @change="toggleRoom(room)" :checked="form.room_ids.includes(room.id)" />
							<label :for="`room_type${index}`">
								<div class="search_image_check_image_box">
									<img v-lazy="room.thumb">
									<p class="search_image_check_title">{{ room.title }}</p>
								</div>
							</label>
						</li>
					</ul>
				</div>
			</div>
			<div class="search_control_btns">
				<button class="white_pink_btn" @click="reset">リセット</button>
				<button type="button" class="submit_pink_btn" @click="search"><img src="/images/search_white.png">検索する</button>
			</div>
		</div>
	</section>
</template>

<script>
import { mapGetters } from 'vuex'
import Form from 'vform'
import Cookies from 'js-cookie'
import {AREA} from '~/plugins/constants'
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import { Settings } from 'luxon'
import Button from '../components/Button.vue'
Settings.defaultLocale = 'ja'

export default {
  components: {
	DatePicker,
    Button
  },

  created () {
	this.initialize()
  },

  metaInfo () {
    return { title: 'パーティー検索' }
  },

  data: () => ({
	area: AREA,
    form: {
	  gender: 'male',
	  your_age: '',
      age_from: '',
	  age_to: '',
	  prefs: '',
	  areas: [],
	  open_at: undefined,
	  open_time: '',
	  keyword: undefined,
	  age_range: undefined,
	  value_sense: undefined,
	  room_ids: []
    },
	remember: false,
	rooms: [],
  }),

  methods: {
    async initialize() {
	   const { data } = await axios.post(`/api/rooms`);
	   this.rooms = data.data

	   if (this.user) {
		   this.form.gender = this.user.profile.gender
		   this.form.your_age = this.user.profile.age
	   }

	   if (window.localStorage.getItem('search_conditions')) {
		   this.form = Object.assign(this.form, JSON.parse(window.localStorage.getItem('search_conditions')))
	   }
    },
    async login () {
      this.$router.push({ name: 'index' })
    },
    reset() {
		window.localStorage.removeItem('search_conditions')
		this.$router.go()
	},
	openAreaSelectModal()
	{
		this.$modal.show('area-select-modal');
	},
	closeAreaSelectModal()
	{
		this.$modal.hide('area-select-modal');
	},
	addToAreaText() {
		var text = document.getElementById("area_selector").value
		this.form.areas.push(text);
	},
	async search() {
	  if (this.user) {
		  const { data } = await axios.post('/api/saveSearchCondition', this.form)
		  this.user.searches = data.searches
	  }
	  window.localStorage.setItem('search_conditions', JSON.stringify(this.form))

      this.$router.push({ name: 'searchresult' })
	},
	toggleRoom(room) {
		if (this.form.room_ids.includes(room.id)) {
			let temp = []
            for (let i = 0; i < this.form.room_ids.length; i++) {
                if (this.form.room_ids[i] != room.id) temp.push(this.form.room_ids[i])
            }
            this.form.room_ids = temp
		} else {
			this.form.room_ids.push(room.id)
		}
	},
	time_value(value) {
		return ("0" + value).slice(-2) + ":00";
	},
	togglePref(value) {
        this.showHobby = false
        if (this.form.areas.includes(value)) {
            let temp = []
            for (let i = 0; i < this.form.areas.length; i++) {
                if (this.form.areas[i] != value) temp.push(this.form.areas[i])
            }
            this.form.areas = temp
        } else {
            this.form.areas.push(value)
        }
        this.$forceUpdate()
        this.showHobby = true
    },
    is_active_prepf(value) {
        return this.form.areas.includes(value)
    }
  },

  computed: {
	  	...mapGetters({
			user: 'auth/user'
		}),
		areaTexts(){
			var areaText = '';
			areaText = this.form.areas.toString();
			if(this.form.areas.length == 0) {
				areaText = "指定されていません"
				this.form.prefs = ''
			} else {
				this.form.prefs = areaText
			}
			return areaText;
		}
  }
}
</script>
<style lang="scss" scoped>
.search_item_hidden {
	margin: 2rem auto;
	justify-content: center;
}
.add_search_item {
	margin-left: 1rem;
}
.result_text {
	margin: 2rem;
    border-bottom: 1px solid #ccc;
    padding: 1rem;
}
.profile_data_hobby_item {
    font-size: 1.4rem;
    line-height: 3.5rem;
    width: 13rem;
    height: 3.5rem;
    text-align: center;
    margin-bottom: 1rem;
    cursor: pointer;
    margin-right: 1.5rem;
}
.profile_data_hobby {
    width: 100%;
    display: flex;
    justify-content: flex-start;
    flex-wrap: wrap;
    align-items: center;
    padding: 2rem;
}
.profile_data_hobby_item:nth-child(5n) {
	margin-right: 0;
} 
</style>
