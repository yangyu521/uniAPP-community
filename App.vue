<script>
	export default {
		onLaunch: function() {
			console.log('App Launch')
			//检测更新
			this.$U.update()
			//网络监听
			this.$U.onNetWork()
			//初始化数据
			
		},
		onShow: function() {
			console.log('App Show')
		},
		onHide: function() {
			console.log('App Hide')
		}
	}
</script>

<style>
	/*每个页面公共css */
	@import "./common/uni.css";
	@import "./common/icon.css";
	@import "./common/animate.min.css";
	@import "./common/free.css";
	@import "./common/common.css"
</style>
