<?php

namespace App\Controller;

use \DateTime;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Form\RegistrationType;
use App\Form\ChangePassType;
use App\Entity\User;

use App\Service\Mailer;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout() {
        throw new \Exception('Logout not enabled in config');
    }

    /**
     * @Route("/pass", name="change_pass")
     */
    public function changePass(Request $req, UserPasswordEncoderInterface $passwordEncoder, Mailer $mailer): Response {
        $form = $this->createForm(ChangePassType::class);

        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $user->setPassword($passwordEncoder->encodePassword($user, $form->getData()->getPassword()));

            $mail = $mailer->createMail();

            $mail->setFrom('admin@crwdogs.com', 'CRW Dogs Admin');
            $mail->addAddress($user->getEmail(), $user->getFirstName() . ' ' . $user->getLastName());
            $mail->Subject = $req->getHost() . ' User Password Changed';

            $msg = 'The password for this email address has recently been changed.<br/>';
            $msg .= '<br/>';
            $msg .= 'If you did not change your email, please reply immediately to resolve the issue.<br/>';
            $msg .= '<br/>';
            $msg .= 'Blue Skies!';

            $mail->msgHTML($msg);
            $mail->send();

            $user->setResetPass(false);
            $user->setTempKey('');

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('profile');
        }
        
        return $this->render('security/changepass.html.twig', [
            'form' => $form->createView(),
            'error' => null,
        ]);
    }

    /**
     * @Route("/register", name="app_register", methods={"GET", "POST"})
     */
    public function register(Request $req, UserPasswordEncoderInterface $passwordEncoder, Mailer $mailer): Response
    {

        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($req);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $password = bin2hex(random_bytes(8));

            $site = $req->getSchemeAndHttpHost();

            $user->setPassword($passwordEncoder->encodePassword($user, $password));

            $user->setRegistered(new DateTime());
            $user->setRegIp($req->getClientIp());
            $user->setTempKey(bin2hex(random_bytes(64)));

            $mail = $mailer->createMail();

            $mail->setFrom('admin@crwdogs.com', 'CRW Dogs Admin');
            $mail->addAddress($user->getEmail(), $user->getFirstName() . ' ' . $user->getLastName());
            $mail->Subject = $req->getHost() . ' User Registration';

            $msg = 'Thank you for your registration, ' . $user->getFirstName() . ' ' . $user->getLastName() . '!<br/>';
            $msg .= '<br/>';
            $msg .= 'Here is the information you provided:<br/>';
            $msg .= 'Nickname: ' . $user->getNick() . '<br/>';
            $msg .= 'Phone: ' . $user->getPhone() . '<br/>';
            $msg .= 'Location: ' . $user->getLocation() . '<br/>';
            $msg .= '<br/>';
            $msg .= 'To login, please visit <a href="' . $site . '/login">' . $site . '/login</a> and login with this email and your password:<br/>';
            $msg .= '<br/>';
            $msg .= $password . '<br/>';
            $msg .= '<br/>';
            $msg .= 'Blue Skies!';

            $mail->msgHTML($msg);
            if (!$mail->send()) {
                $error = 'There was an error sending your user registration email: ' . $mail->ErrorInfo . '<br>';
                $error .= 'Email us at <a href="mailto:admin@crwdogs.com">admin@crwdogs.com</a> if you need assistance.';

                return $this->render('security/register.html.twig', [
                    'form' => $form->createView(),
                    'error' => $error
                ]);
            }
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView(),
            'error' => null,
        ]);
    }
}
