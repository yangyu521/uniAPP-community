<template>
	<view>
		<uni-status-bar></uni-status-bar>
		<view>
			<view class="iconfont icon-guanbi flex align-center justify-center font-lg" style="width: 100rpx;height: 100rpx;"  hover-class="bg-light" @click="back"></view>	
		</view>
		
		<view class="text-center" style="padding-top: 130rpx;padding-bottom: 70rpx;font-size: 55rpx;">{{status ? '手机验证码登陆' : '账号密码登录'}}</view>
		
		<view class="px-2">
			<template v-if="!status">
				<view class="mb-2">
					<input type="text" v-model="username" placeholder="昵称/手机号/邮箱" class="border-bottom p-2"/>
				</view>
				<view class="mb-2 flex align-stretch">
					<input type="password" v-model="password" placeholder="请输入密码" class="border-bottom p-2 flex-1"/>
					<view class="border-bottom flex align-center justify-center font text-muted" style="width: 140rpx;">忘记密码?</view>
				</view>
			</template>
			<template v-else>
				<view class="mb-2 flex align-stretch">
					<view class="border-bottom flex align-center justify-center font px-2">+86</view>
					<input type="text" v-model="phone" placeholder="手机号" class="border-bottom p-2 flex-1"/>
				</view>
				<view class="mb-2 flex align-stretch">
					<input type="password" v-model="code" placeholder="请输入验证码" class="border-bottom p-2 flex-1"/>
					<view class="border-bottom flex align-center justify-center font-sm text-white" :class="codeTime > 0 ? 'bg-main-disabled' : 'bg-main'" style="width: 180rpx;" @click="getCode">{{codeTime > 0 ? codeTime + 's' : '获取验证码'}}</view>
				</view>
			</template>
			<view class="py-2 px-3">
				<button class="bg-main text-white" style="border-radius: 50rpx;border: 0;" type="primary" :disabled="disabled" :class="disabled ? 'bg-main-disabled' : ''" @click="submit">登录</button>
			</view>
			<view class="flex align-center justify-center pt-2 pb-4">
				<view class="text-primary font-sm" @click="changeStatus">{{status ? '账号密码登录' : '验证码登录'}}</view>
				<text class="text-muted mx-2">|</text>
				<view class="text-primary font-sm">登陆遇到问题</view>
			</view>
			<view class="flex align-center justify-center">
				<view style="height: 1rpx;background-color: #D8D8D8;width: 100rpx;"></view>
				<view class="mx-2 text-muted">社交账号登陆</view>
				<view style="height: 1rpx;background-color: #D8D8D8;width: 100rpx;"></view>
			</view>
			
		</view>
		<other-login></other-login>
		
		<view class="flex align-center justify-center text-muted">
			注册即代表同意<text class="text-primary">《xxx社区协议》</text>
		</view>
	</view>
</template>

<script>
	import uniStatusBar from "@/components/uni-ui/uni-status-bar/uni-status-bar.vue"
	import otherLogin from "@/components/common/other-login.vue"
	export default {
		components:{
			uniStatusBar,
			otherLogin
		},
		data() {
			return {
				status:false,
				username:"",
				password:"",
				code:"",
				phone:"",
				codeTime:0
			}
		},
		onLoad() {
		},
		computed:{
			disabled(){
				if((this.username === "" || this.password === "") && (this.phone === "" || this.code === "")){
					return true
				}else{
					return false;
				}
			}
		},
		methods: {
			back(){
				uni.navigateBack({
					delta:1
				})
			},
			//初始化表单
			initForm(){
				this.username = '',
				this.password = '',
				this.phone = '',
				this.code = ''
			},
			//切换登陆方式
			changeStatus(){
				this.initForm();
				this.status = !this.status
			},
			getCode(){
				if(this.codeTime > 0){
					return;
				}
				if(!this.validate()) return;
				this.codeTime = 60;
				let timer = setInterval(()=>{
					if(this.codeTime >= 1){
						this.codeTime--
					}else{
						this.codeTime = 0;
						clearInterval(timer)
					}
					
				},1000)
			},
			//表单验证
			validate(){
				let pas =/^1[3|4|5|7|8]\d{9}$/;
				if(!pas.test(this.phone)){
					uni.showToast({
						title:"手机格式不正确"
					})
					return false
				}
				return true;
			},
			submit(){
				//表单验证
				if(!this.validate()) return;
				//提交后端
			}
			
 		}
	}
</script>

<style>

</style>
