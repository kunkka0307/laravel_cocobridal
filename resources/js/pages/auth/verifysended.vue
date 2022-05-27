<template>
  <section class="sec_register container3">
    <div class="col-lg-8 m-auto">
        <h2 class="verify-sended">
            仮申込を受付けました。<br/>登録されたメールアドレスにメールを送信しました。<br/>メール内のリンクをクリックして登録をしてください。
        </h2>
        <div class="text-center">
          <router-link :to="{name: 'index'}" class="btn btn-primary btn-custom" style="margin-bottom:40px;">TOPに戻る</router-link>
        </div>
    </div>
  </section>
</template>
<script>

export default {
  middleware: 'guest',
  layout: 'default',
  metaInfo () {
    return { title: '入試の仮申込を受付けました' }
  },
}
</script>
<style>
    .sec_register {
        margin-top: 8rem;
        text-align: center;
    }
    .verify-sended {
        font-size: 1.6rem;
    }
    .text-center {
        font-size: 1.8rem;
        margin-top: 6rem;
        padding-bottom: 4rem;
    }

    @media screen and (max-width:768px) {
        .verify-sended {
          font-size: 3.4vw;
          line-height: 1.5;
        }
    }
    


</style>