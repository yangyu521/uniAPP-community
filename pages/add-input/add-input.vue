<template>
	<view>
		<!-- 自定义导航 -->
		<uni-nav-bar left-icon="back" statusBar :border="false" @clickLeft="goBack">
			<view class="flex align-center justify-center w-100">
				所有人可见<text class="iconfont icon-shezhi pl-1"></text>
			</view>
		</uni-nav-bar>
		<!-- 文本域 -->
		<textarea v-model="content" placeholder="说一句话吧~" class="uni-textarea px-2" />
		<!-- 图片上传 -->
		<upload-image ref="uploadImage" :show="show" :list="imageList" @change="changeImage"></upload-image>
		<!-- 底部操作条 -->
		<view class="fixed-bottom bg-white flex align-center" style="85rpx">
			<view class="iconfont icon-caidan footer-btn animated" hover-class="jello">	</view>
			<view class="iconfont icon-huati footer-btn animated" hover-class="jello" ></view>
			<view class="iconfont icon-tupian footer-btn animated" @click="iconClickEvent('uploadImage')" hover-class="jello"></view>
			<view class="bg-main text-white ml-auto flex align-center justify-center rounded mr-2" style="width: 140rpx;height: 60rpx;">发送</view>
		</view>
	</view>
</template>

<script>
	import uniNavBar from "@/components/uni-ui/uni-nav-bar/uni-nav-bar.vue"
	import uploadImage from "@/components/common/upload-image.vue"
	export default {
		components:{
			uniNavBar,
			uploadImage
		},
		data() {
			return {
				content:"",
				imageList:[],
				showBack:false
			}
		},
		computed:{
			show(){
				return this.imageList.length > 0;
			}
		},
		//监听返回
		onBackPress() {
			if((this.content !== "" || this.imageList.length >0) && !this.showBack ){
				uni.showModal({
					content:"需要保存草稿吗？",
					showCancel:true,
					cancelText:"不保存",
					confirmText:"保存",
					success:res=>{
						if(res.confirm){
							this.store()
							uni.navigateBack({delta:1})
						}else{
							//点击取消
							uni.removeStorage({
								key:"add-input"
							})
							uni.navigateBack({delta:1})
						}
						
					}
				})
				this.showBack = true;
				return true;
			}
		},
		//页面加载时
		onLoad(){
			uni.getStorage({
				key:"add-input",
				success:res=>{
					if(res.data){
						let result = JSON.parse(res.data)
						this.content = result.content
						this.imageList = result.imageList
					}
				}
			})
		},
		methods: {
			iconClickEvent(e){
				switch(e){
					case 'uploadImage':
					this.$refs.uploadImage.chooseImage()
					break
				}
			},
			//点击返回
			goBack(){
				uni.navigateBack({delta:1})
			},
			changeImage(e){
				// console.log(e)
				this.imageList = e;
			},
			//保存操作
			store(){
				let obj = {
					content:this.content,
					imageList:this.imageList
				}
				uni.setStorage({
					key:"add-input",
					data:JSON.stringify(obj)
				})
			}
		},
		
	}
</script>

<style>
.footer-btn{
	width: 86rpx;
	height: 86rpx;
	display: flex;
	justify-content: center;
	align-items: center;
	font-size: 50rpx;
}
</style>
