<template>
    <div class="sidebar_layout container2">
		<section class="sec_favorite_list container2">
			<h2 class="favorite_title"><img src="/images/search_black.png">保存している検索条件</h2>
			<div v-if="user.searches.length == 0" class="text-gray text-center">検索条件はありません。</div>
			<div class="register_box saved_list">
				<div class="saved_list_item" v-for="(search, index) in user.searches" :key="index">
					<div class="saved_list_item_title">
						<div class="saved_list_item_title_text">検索条件{{ index + 1 }}：<span>{{ search.your_age }}</span></div>
						<button class="saved_item_del_btn" @click="deleteSearch(search.id)" type="button"><img src="/images/bin.png">削除</button>
					</div>
					<div class="saved_list_item_content">
						<span v-if="search.prefs_label != ''">エリア：{{ search.prefs_label }}<br/></span>
						<span v-if="search.open_time && search.open_time != ''">開催日：{{ search.open_time }} ~ <br/></span>
						<span v-if="search.age_label != ''">お相手の年齢：{{ search.age_label }} </span>
					</div>
					<div class="search_control_btns">
						<button class="submit_pink_btn"><img src="/images/search_white.png">この条件で検索</button>
						<button class="white_pink_btn">編集する</button>
					</div>
				</div>
			</div>
		</section>
	</div>
</template>

<script>
import { mapGetters } from 'vuex'
import Form from 'vform'

export default {
  components: {
  },

  middleware: 'auth',
  layout: 'sidebar',

  metaInfo () {
    return { title: "保存している検索条件" }
  },

  data: () => ({
    form: new Form({
      email: '',
      password: ''
    }),
    remember: false
  }),

  methods: {
		async deleteSearch(id) {
			const { data } = await axios.post('/api/search/delete', {
				id: id
			})
			this.user.searches = data.searches
		}
  },
  computed: mapGetters({
    user: 'auth/user'
  }),
}
</script>
