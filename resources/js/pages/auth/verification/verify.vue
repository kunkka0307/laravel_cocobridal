<template>
  <div class="row sec_register">
    <div class="col-lg-8 m-auto">
      <card title="メール確認">
        <template v-if="success">
          <div class="alert alert-success" role="alert">
           メールアドレス確認されました。
          </div>
          <router-link :to="{ name: 'login'}" class="btn btn-primary">
            ログイン画面へ
          </router-link>
        </template>
        <template v-else>
          <div class="alert alert-danger" role="alert">
            {{ error || $t('failed_to_verify_email') }}
          </div>

          <router-link :to="{ name: 'verification.resend' }" class="small float-right">
            確認コード再送信
          </router-link>
        </template>
      </card>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

const qs = (params) => Object.keys(params).map(key => `${key}=${params[key]}`).join('&')

export default {
  async beforeRouteEnter (to, from, next) {
    try {
      const { data } = await axios.post(`/api/email/verify/${to.params.id}?${qs(to.query)}`)

      next(vm => { vm.success = data.status })
    } catch (e) {
      next(vm => { vm.error = e.response.data.status })
    }
  },

  middleware: 'guest',

  metaInfo () {
    return { title: this.$t('verify_email') }
  },

  data: () => ({
    error: '',
    success: true
  })
}
</script>
<style>
    .sec_register {
        margin-top: 8rem;
        text-align: center;
    }
</style>
